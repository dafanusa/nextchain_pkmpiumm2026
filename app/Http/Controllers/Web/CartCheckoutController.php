<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartCheckoutRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\DeliverySchedule;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CartCheckoutController extends Controller
{
    public function checkout(): View
    {
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id(), 'status' => 'active'],
            ['status' => 'active']
        );

        $items = $cart->items()->with('product')->get();
        $cartItems = $items->map(fn ($item) => $this->mapCartItem($item))->values();
        $now = now('Asia/Jakarta');
        $schedules = DeliverySchedule::query()
            ->where('is_active', true)
            ->orderBy('delivery_date')
            ->orderBy('delivery_time')
            ->get()
            ->filter(fn (DeliverySchedule $schedule) => $this->isScheduleAvailable($schedule, $now))
            ->values();

        return view('checkout.checkout-cart', compact('cartItems', 'schedules'));
    }

    public function storePayment(CartCheckoutRequest $request): RedirectResponse
    {
        $cart = Cart::firstOrCreate(
            ['user_id' => $request->user()->id, 'status' => 'active'],
            ['status' => 'active']
        );

        $items = $cart->items()->with('product')->get();
        $selectedItems = $items->where('selected', true);

        if ($selectedItems->isEmpty()) {
            return redirect()->route('checkout.cart');
        }

        $subtotal = $selectedItems->sum(fn ($item) => $item->qty * $item->price);
        $shipping = 25000;
        $total = $subtotal + $shipping;
        $orderNumber = 'NC-CART-'.date('ymd').'-'.Str::upper(Str::random(5));
        $shippingMethod = $request->input('shipping_method');
        $deliverySchedule = null;
        $shippingDate = $request->input('shipping_date');
        $shippingTime = $request->input('shipping_time');

        if (in_array($shippingMethod, ['Pengiriman terjadwal', 'Pickup di farm'], true)) {
            $expectedType = $shippingMethod === 'Pickup di farm' ? 'pickup' : 'scheduled';
            $deliverySchedule = DeliverySchedule::query()
                ->whereKey($request->input('delivery_schedule_id'))
                ->where('is_active', true)
                ->where('schedule_type', $expectedType)
                ->first();

            if ($deliverySchedule && $this->isScheduleAvailable($deliverySchedule, now('Asia/Jakarta'))) {
                $shippingDate = $deliverySchedule->delivery_date;
                $shippingTime = $deliverySchedule->delivery_time;
            } else {
                $deliverySchedule = null;
            }
        }

        $order = Order::create([
            'user_id' => $request->user()->id,
            'order_number' => $orderNumber,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'subtotal' => $subtotal,
            'shipping_fee' => $shipping,
            'total' => $total,
            'buyer_name' => $request->input('name'),
            'buyer_phone' => $request->input('phone'),
            'buyer_address' => $request->input('address'),
            'shipping_method' => $shippingMethod,
            'delivery_schedule_id' => $deliverySchedule?->id,
            'shipping_date' => $shippingDate,
            'shipping_time' => $shippingTime,
            'shipping_status' => 'processing',
            'note' => $request->input('note'),
        ]);

        foreach ($selectedItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'unit' => $item->product?->unit ?? '',
                'price' => $item->price,
                'qty' => $item->qty,
                'line_total' => $item->qty * $item->price,
            ]);
        }

        $selectedItems->each->delete();

        return redirect()->route('checkout.cart.payment', ['order' => $order->order_number]);
    }

    public function payment(Request $request): View|RedirectResponse
    {
        $orderNumber = (string) $request->query('order', '');
        if ($orderNumber === '') {
            return redirect()->route('checkout.cart');
        }

        $order = Order::query()
            ->where('order_number', $orderNumber)
            ->where('user_id', $request->user()->id)
            ->with(['items.product', 'deliverySchedule'])
            ->firstOrFail();

        $orderItems = $order->items->map(fn (OrderItem $item) => $this->mapOrderItem($item))->values();
        $midtransClientKey = config('services.midtrans.client_key');

        return view('payment.payment-cart', [
            'order' => $order,
            'orderItems' => $orderItems,
            'buyer' => [
                'name' => $order->buyer_name,
                'phone' => $order->buyer_phone,
                'address' => $order->buyer_address,
                'shipping_method' => $order->shipping_method,
                'shipping_date' => optional($order->shipping_date)->format('Y-m-d'),
                'shipping_time' => $order->shipping_time,
                'delivery_destination' => $order->deliverySchedule?->destination,
                'shipping_status' => $order->shipping_status ?? 'processing',
                'note' => $order->note,
            ],
            'midtransClientKey' => $midtransClientKey,
        ]);
    }

    public function midtransToken(Request $request): JsonResponse
    {
        $orderNumber = (string) $request->query('order', '');
        if ($orderNumber === '') {
            return response()->json(['error' => 'Order tidak ditemukan.'], 404);
        }

        $order = Order::query()
            ->where('order_number', $orderNumber)
            ->where('user_id', $request->user()->id)
            ->with('items.product')
            ->first();

        if (! $order) {
            return response()->json(['error' => 'Order tidak ditemukan.'], 404);
        }

        $itemDetails = $order->items->map(function (OrderItem $item) {
            return [
                'id' => (string) $item->product_id,
                'price' => (int) $item->price,
                'quantity' => (int) $item->qty,
                'name' => $item->product?->name ?? 'Produk',
            ];
        })->values()->all();

        if (empty($itemDetails)) {
            return response()->json(['error' => 'Tidak ada item valid.'], 400);
        }

        $itemDetails[] = [
            'id' => 'shipping',
            'price' => (int) $order->shipping_fee,
            'quantity' => 1,
            'name' => 'Ongkir',
        ];

        $payload = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => $order->buyer_name ?: 'Pembeli',
                'phone' => $order->buyer_phone ?: '',
                'shipping_address' => [
                    'address' => $order->buyer_address ?: '',
                ],
            ],
        ];

        $method = $request->query('method');
        if (! empty($method) && $method !== 'all') {
            $payload['enabled_payments'] = [$method];
        }

        $serverKey = config('services.midtrans.server_key');
        if (empty($serverKey)) {
            return response()->json(['error' => 'MIDTRANS_SERVER_KEY belum diatur.'], 500);
        }

        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])
            ->withBasicAuth($serverKey, '')
            ->asJson()
            ->post('https://app.sandbox.midtrans.com/snap/v1/transactions', $payload);

        if (! $response->successful()) {
            return response()->json(['error' => 'Gagal membuat token Midtrans.', 'detail' => $response->body()], 500);
        }

        $data = $response->json();
        if (! isset($data['token'])) {
            return response()->json(['error' => 'Token Midtrans tidak ditemukan.', 'detail' => $data], 500);
        }

        return response()->json(['token' => $data['token']]);
    }

    private function mapCartItem(CartItem $item): array
    {
        $product = $item->product;
        $image = $product?->image;
        $imageUrl = $this->resolveImageUrl($image);

        return [
            'id' => $item->id,
            'product_id' => $product?->id,
            'name' => $product?->name ?? 'Produk',
            'price' => $item->price,
            'unit' => $product?->unit ?? '',
            'image' => $image,
            'image_url' => $imageUrl,
            'qty' => $item->qty,
            'selected' => $item->selected,
        ];
    }

    private function mapOrderItem(OrderItem $item): array
    {
        $product = $item->product;
        $image = $product?->image;
        $imageUrl = $this->resolveImageUrl($image);

        return [
            'id' => $item->id,
            'product_id' => $item->product_id,
            'name' => $product?->name ?? 'Produk',
            'price' => $item->price,
            'unit' => $item->unit,
            'image' => $image,
            'image_url' => $imageUrl,
            'qty' => $item->qty,
            'line_total' => $item->line_total,
        ];
    }

    private function resolveImageUrl(?string $image): ?string
    {
        if (! $image) {
            return asset('assets/ternakayam.jpg');
        }

        return str_starts_with($image, 'products/')
            ? asset('storage/'.$image)
            : asset('assets/'.$image);
    }

    private function isScheduleAvailable(DeliverySchedule $schedule, Carbon $now): bool
    {
        if (! $schedule->delivery_date) {
            return false;
        }

        $today = $now->copy()->startOfDay();
        $scheduleDate = $schedule->delivery_date->copy()->startOfDay();

        if ($scheduleDate->lt($today)) {
            return false;
        }

        if ($scheduleDate->gt($today)) {
            return true;
        }

        $endTime = $this->extractEndTime($schedule->delivery_time);
        if (! $endTime) {
            return true;
        }

        $endDateTime = Carbon::createFromFormat(
            'Y-m-d H:i',
            $scheduleDate->format('Y-m-d').' '.$endTime,
            'Asia/Jakarta'
        );

        return $now->lte($endDateTime);
    }

    private function extractEndTime(?string $timeRange): ?string
    {
        if (! $timeRange) {
            return null;
        }

        preg_match_all('/(\d{1,2})[.:](\d{2})/', $timeRange, $matches);
        if (empty($matches[0])) {
            return null;
        }

        $lastIndex = count($matches[0]) - 1;
        $hour = str_pad($matches[1][$lastIndex], 2, '0', STR_PAD_LEFT);
        $minute = $matches[2][$lastIndex];

        return $hour.':'.$minute;
    }
}
