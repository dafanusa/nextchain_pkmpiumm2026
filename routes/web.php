<?php

use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DeliveryScheduleController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\FinancialReportController;
use App\Http\Controllers\Admin\NegotiationOfferController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PriceHistoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\CartCheckoutController;
use App\Http\Controllers\Web\CartController as WebCartController;
use App\Http\Controllers\Web\InvoiceController;
use App\Http\Controllers\Web\NegotiationController as WebNegotiationController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\TestimonialWebController;
use App\Models\DeliverySchedule;
use App\Models\NegotiationOffer;
use App\Models\Payment;
use App\Models\PriceHistory;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

/* HOME */
Route::get('/', [HomeController::class, 'index'])->name('home');

/* AUTH (WEB) */
Route::get('/register', [WebAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [WebAuthController::class, 'register'])->middleware('throttle:register');
Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [WebAuthController::class, 'login'])->middleware('throttle:login');
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profil/photo', [ProfileController::class, 'destroyPhoto'])->name('profile.photo.destroy');
});

Route::post('/testimoni', [TestimonialWebController::class, 'store'])
    ->middleware('auth')
    ->name('testimonials.store');

Route::get('/nota/{token}', [InvoiceController::class, 'public'])->name('invoice.public');
Route::get('/n/{code}', [InvoiceController::class, 'publicShort'])->name('invoice.short');
Route::get('/invoice/{order}/preview', [InvoiceController::class, 'preview'])
    ->middleware('auth')
    ->name('invoice.preview');
Route::get('/invoice/{order}/download', [InvoiceController::class, 'download'])
    ->middleware('auth')
    ->name('invoice.download');
Route::post('/invoice/{order}/email', [InvoiceController::class, 'sendEmail'])
    ->middleware('auth')
    ->name('invoice.email');
Route::get('/invoice/{order}/whatsapp', [InvoiceController::class, 'whatsapp'])
    ->middleware('auth')
    ->name('invoice.whatsapp');

/* ADMIN */
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('users', UserController::class)->names('admin.users');
    Route::get('users-detail', [UserController::class, 'detail'])->name('admin.users.detail');
    Route::resource('products', ProductController::class)->names('admin.products')->except(['show']);
    Route::get('products/price', [ProductController::class, 'price'])->name('admin.products.price');
    Route::patch('products/{product}/price', [ProductController::class, 'updatePrice'])->name('admin.products.price.update');
    Route::get('price-histories', [PriceHistoryController::class, 'index'])->name('admin.price-histories.index');
    Route::resource('offers', NegotiationOfferController::class)->names('admin.offers')->only(['index', 'edit', 'update', 'destroy']);
    Route::resource('delivery-schedules', DeliveryScheduleController::class)
        ->names('admin.delivery-schedules')
        ->except(['show']);
    Route::patch('offers/{offer}/approve', [NegotiationOfferController::class, 'approve'])->name('admin.offers.approve');
    Route::patch('offers/{offer}/reject', [NegotiationOfferController::class, 'reject'])->name('admin.offers.reject');
    Route::resource('orders', OrderController::class)->names('admin.orders')->only(['index', 'show', 'update', 'destroy']);
    Route::resource('payments', PaymentController::class)->names('admin.payments')->only(['index', 'edit', 'update', 'destroy']);
    Route::get('financial-reports', [FinancialReportController::class, 'index'])->name('admin.financial-reports.index');
    Route::post('financial-reports', [FinancialReportController::class, 'store'])->name('admin.financial-reports.store');
    Route::get('financial-reports/{report}/csv', [FinancialReportController::class, 'csv'])->name('admin.financial-reports.csv');
    Route::get('financial-reports/{report}/download', [FinancialReportController::class, 'download'])->name('admin.financial-reports.download');
    Route::delete('financial-reports/{report}', [FinancialReportController::class, 'destroy'])->name('admin.financial-reports.destroy');
    Route::get('expenses', [ExpenseController::class, 'index'])->name('admin.expenses.index');
    Route::post('expenses', [ExpenseController::class, 'store'])->name('admin.expenses.store');
    Route::get('expenses/csv', [ExpenseController::class, 'csv'])->name('admin.expenses.csv');
    Route::get('expenses/download', [ExpenseController::class, 'download'])->name('admin.expenses.download');
    Route::delete('expenses/{expense}', [ExpenseController::class, 'destroy'])->name('admin.expenses.destroy');
    Route::resource('testimonials', TestimonialController::class)->names('admin.testimonials')->only(['index', 'edit', 'update', 'destroy']);
    Route::patch('testimonials/{testimonial}/approve', [TestimonialController::class, 'approve'])->name('admin.testimonials.approve');
    Route::resource('carts', CartController::class)->names('admin.carts')->only(['index', 'show', 'destroy']);
});

// Halaman lokasi/testimoni/galeri disatukan di home.
// Halaman tentang disatukan di home.

/* PRODUK */
Route::get('/produk', function () {
    $products = Product::query()
        ->where('is_active', true)
        ->latest('id')
        ->get();

    if ($products->count() === 1) {
        return redirect()->route('produk.detail', $products->first());
    }

    return view('products.product', compact('products'));
})->name('produk');

/* DETAIL */
Route::get('/produk/{product}', function (Product $product) {
    abort_if(! $product->is_active, 404);
    $product->loadMissing('images');
    $images = collect([$product->image_url])
        ->merge($product->images->pluck('image_url'))
        ->filter()
        ->unique()
        ->values()
        ->all();
    $today = now('Asia/Jakarta')->startOfDay();
    $histories = PriceHistory::query()
        ->where('product_id', $product->id)
        ->orderBy('price_date')
        ->get();

    if ($histories->isEmpty()) {
        $histories = collect([
            new PriceHistory([
                'price_date' => $today->copy(),
                'price_min' => $product->price_min,
                'price_max' => $product->price_max,
            ]),
        ]);
    }

    $dailyStart = $today->copy()->subDays(13);
    $historyMap = $histories->keyBy(fn (PriceHistory $history) => $history->price_date->format('Y-m-d'));
    $dailyLabels = [];
    $dailyMin = [];
    $dailyMax = [];

    $current = $dailyStart->copy();
    while ($current->lte($today)) {
        $key = $current->format('Y-m-d');
        $history = $historyMap->get($key);
        $dailyLabels[] = $current->format('d M');
        $dailyMin[] = $history?->price_min;
        $dailyMax[] = $history?->price_max;
        $current->addDay();
    }

    $weeklyStart = $today->copy()->startOfWeek(Carbon::MONDAY)->subWeeks(7);
    $weeklyLabels = [];
    $weeklyMin = [];
    $weeklyMax = [];

    for ($week = 0; $week < 8; $week++) {
        $start = $weeklyStart->copy()->addWeeks($week);
        $end = $start->copy()->endOfWeek(Carbon::SUNDAY);
        $weekData = $histories->filter(fn (PriceHistory $history) => $history->price_date->between($start, $end));
        $weeklyLabels[] = $start->format('d M');
        $weeklyMin[] = $weekData->isEmpty() ? null : (int) round($weekData->avg('price_min'));
        $weeklyMax[] = $weekData->isEmpty() ? null : (int) round($weekData->avg('price_max'));
    }

    $latestPriceHistory = PriceHistory::query()
        ->where('product_id', $product->id)
        ->latest('updated_at')
        ->first();
    $priceUpdatedAt = $latestPriceHistory?->updated_at;
    $stockUpdatedAt = $product->stock_updated_at;

    return view('products.detail', compact(
        'product',
        'images',
        'dailyLabels',
        'dailyMin',
        'dailyMax',
        'weeklyLabels',
        'weeklyMin',
        'weeklyMax',
        'priceUpdatedAt',
        'stockUpdatedAt'
    ));
})->name('produk.detail');

/* NEGOSIASI */
Route::get('/produk/{product}/negosiasi', function (Product $product) {
    abort_if(! $product->is_active, 404);
    $offers = \App\Models\NegotiationOffer::with('user')
        ->where('product_id', $product->id)
        ->latest('id')
        ->take(12)
        ->get();

    $acceptedOffer = \App\Models\NegotiationOffer::with('user')
        ->where('product_id', $product->id)
        ->where('status', 'accepted')
        ->latest('accepted_at')
        ->first();

    $userOffer = Auth::check()
        ? \App\Models\NegotiationOffer::query()
            ->where('product_id', $product->id)
            ->where('user_id', Auth::id())
            ->latest('id')
            ->first()
        : null;

    $messages = $userOffer
        ? $userOffer->messages()->with('user')->oldest('id')->get()
        : collect();

    return view('negotiation.negotiation', compact('product', 'offers', 'acceptedOffer', 'userOffer', 'messages'));
})->name('produk.negosiasi');
Route::post('/produk/{id}/negosiasi', [WebNegotiationController::class, 'store'])
    ->middleware('auth')
    ->name('produk.negosiasi.store');
Route::post('/produk/{id}/negosiasi/pesan', [WebNegotiationController::class, 'storeMessage'])
    ->middleware('auth')
    ->name('produk.negosiasi.message');

/* CHECKOUT (SIMULASI FLOW) */
$isScheduleAvailable = function (DeliverySchedule $schedule, Carbon $now): bool {
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

    $matches = [];
    preg_match_all('/(\d{1,2})[.:](\d{2})/', (string) $schedule->delivery_time, $matches);
    if (empty($matches[0])) {
        return true;
    }

    $lastIndex = count($matches[0]) - 1;
    $hour = str_pad($matches[1][$lastIndex], 2, '0', STR_PAD_LEFT);
    $minute = $matches[2][$lastIndex];
    $endDateTime = Carbon::createFromFormat(
        'Y-m-d H:i',
        $scheduleDate->format('Y-m-d').' '.$hour.':'.$minute,
        'Asia/Jakarta'
    );

    return $now->lte($endDateTime);
};

Route::get('/checkout/{product}', function (Product $product) use ($isScheduleAvailable) {
    abort_if(! $product->is_active, 404);
    $qty = max($product->moq, (int) request('qty', $product->moq));
    $unitPrice = (int) round(($product->price_min + $product->price_max) / 2);
    $subtotal = $unitPrice * $qty;
    $shipping = 25000;
    $total = $subtotal + $shipping;
    $orderId = 'NC-'.date('ymd').'-'.str_pad((string) $product->id, 3, '0', STR_PAD_LEFT);
    $now = now('Asia/Jakarta');
    $schedules = DeliverySchedule::query()
        ->where('is_active', true)
        ->orderBy('delivery_date')
        ->orderBy('delivery_time')
        ->get()
        ->filter(fn (DeliverySchedule $schedule) => $isScheduleAvailable($schedule, $now))
        ->values();

    return view('checkout.checkout', compact('product', 'qty', 'unitPrice', 'subtotal', 'shipping', 'total', 'orderId', 'schedules'));
})->middleware('auth')->name('checkout');

Route::get('/checkout/{product}/payment', function (Product $product) use ($isScheduleAvailable) {
    abort_if(! $product->is_active, 404);
    $qty = max($product->moq, (int) request('qty', $product->moq));
    $unitPrice = (int) round(($product->price_min + $product->price_max) / 2);
    $subtotal = $unitPrice * $qty;
    $shipping = 25000;
    $total = $subtotal + $shipping;
    $orderId = 'NC-'.date('ymd').'-'.str_pad((string) $product->id, 3, '0', STR_PAD_LEFT);
    $midtransClientKey = config('services.midtrans.client_key');
    $shippingMethod = (string) request('shipping_method', '');
    $deliverySchedule = null;
    $shippingDate = request('shipping_date', '');
    $shippingTime = request('shipping_time', '');

    if ($shippingMethod !== '') {
        $validated = request()->validate([
            'shipping_method' => ['required', 'string', 'max:120'],
            'delivery_schedule_id' => [
                Rule::requiredIf(in_array($shippingMethod, ['Pengiriman terjadwal', 'Pickup di farm'], true)),
                'integer',
                Rule::exists('delivery_schedules', 'id')->where('is_active', true),
            ],
            'shipping_date' => ['nullable', Rule::requiredIf(! in_array($shippingMethod, ['Pengiriman terjadwal', 'Pickup di farm'], true)), 'date'],
            'shipping_time' => ['nullable', Rule::requiredIf(! in_array($shippingMethod, ['Pengiriman terjadwal', 'Pickup di farm'], true)), 'string', 'max:40'],
        ]);

        $shippingDate = $validated['shipping_date'] ?? '';
        $shippingTime = $validated['shipping_time'] ?? '';

        if (in_array($shippingMethod, ['Pengiriman terjadwal', 'Pickup di farm'], true)) {
            $expectedType = $shippingMethod === 'Pickup di farm' ? 'pickup' : 'scheduled';
            $deliverySchedule = DeliverySchedule::query()
                ->whereKey($validated['delivery_schedule_id'])
                ->where('is_active', true)
                ->where('schedule_type', $expectedType)
                ->first();

            if ($deliverySchedule && $isScheduleAvailable($deliverySchedule, now('Asia/Jakarta'))) {
                $shippingDate = $deliverySchedule->delivery_date->format('Y-m-d');
                $shippingTime = $deliverySchedule->delivery_time;
            } else {
                return redirect()->back()->withErrors([
                    'delivery_schedule_id' => 'Jadwal sudah lewat. Silakan pilih jadwal lain.',
                ])->withInput();
            }
        }
    }

    $buyer = [
        'name' => request('name', ''),
        'phone' => request('phone', ''),
        'address' => request('address', ''),
        'shipping_method' => $shippingMethod,
        'shipping_date' => $shippingDate,
        'shipping_time' => $shippingTime,
        'delivery_destination' => $deliverySchedule?->destination,
        'note' => request('note', ''),
    ];

    if (Auth::check()) {
        $order = \App\Models\Order::firstOrCreate(
            ['order_number' => $orderId],
            [
                'user_id' => Auth::id(),
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'subtotal' => $subtotal,
                'shipping_fee' => $shipping,
                'total' => $total,
                'buyer_name' => $buyer['name'] ?: Auth::user()->name,
                'buyer_phone' => $buyer['phone'] ?: '-',
                'buyer_address' => $buyer['address'] ?: '-',
                'shipping_method' => $buyer['shipping_method'] ?: null,
                'delivery_schedule_id' => $deliverySchedule?->id,
                'shipping_date' => $buyer['shipping_date'] ?: null,
                'shipping_time' => $buyer['shipping_time'] ?: null,
                'shipping_status' => 'processing',
                'note' => $buyer['note'] ?: null,
            ]
        );

        if (! $order->items()->where('product_id', $product->id)->exists()) {
            $order->items()->create([
                'product_id' => $product->id,
                'unit' => $product->unit,
                'price' => $unitPrice,
                'qty' => $qty,
                'line_total' => $subtotal,
            ]);
        }
        $buyer['shipping_status'] = $order->shipping_status ?? 'processing';
    }

    return view('payment.payment', compact('product', 'qty', 'unitPrice', 'subtotal', 'shipping', 'total', 'orderId', 'midtransClientKey', 'buyer'));
})->middleware('auth')->name('checkout.payment');

Route::get('/checkout/{product}/midtrans-token', function (Product $product) {
    abort_if(! $product->is_active, 404);

    $qty = max($product->moq, (int) request('qty', $product->moq));
    $unitPrice = (int) round(($product->price_min + $product->price_max) / 2);
    $subtotal = $unitPrice * $qty;
    $shipping = 25000;
    $total = $subtotal + $shipping;
    $orderId = 'NC-'.date('ymd').'-'.str_pad((string) $product->id, 3, '0', STR_PAD_LEFT).'-'.substr(uniqid(), -5);

    $payload = [
        'transaction_details' => [
            'order_id' => $orderId,
            'gross_amount' => $total,
        ],
        'item_details' => [
            [
                'id' => (string) $product->id,
                'price' => $unitPrice,
                'quantity' => $qty,
                'name' => $product->name,
            ],
            [
                'id' => 'shipping',
                'price' => $shipping,
                'quantity' => 1,
                'name' => 'Ongkir',
            ],
        ],
        'customer_details' => [
            'first_name' => request('name', 'Pembeli'),
            'phone' => request('phone', ''),
            'shipping_address' => [
                'address' => request('address', ''),
            ],
        ],
    ];

    $method = request('method');
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
})->middleware('auth')->name('checkout.midtrans');

Route::get('/checkout/{product}/success', function (Product $product) {
    abort_if(! $product->is_active, 404);
    $orderId = request('orderId', 'NC-'.date('ymd').'-'.str_pad((string) $product->id, 3, '0', STR_PAD_LEFT));
    $method = request('method');
    $order = \App\Models\Order::query()
        ->where('order_number', $orderId)
        ->where('user_id', Auth::id())
        ->with(['items.product', 'deliverySchedule', 'payments'])
        ->first();

    if ($order && $order->payment_status !== 'paid') {
        $order->deductStockIfNeeded();
        $order->ensureInvoiceData();
        $order->update(['payment_status' => 'paid']);
        if (! Payment::query()->where('order_id', $order->id)->where('status', 'paid')->exists()) {
            Payment::query()->create([
                'order_id' => $order->id,
                'provider' => 'midtrans',
                'method' => $method !== 'all' ? $method : null,
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        }
        \App\Jobs\SendInvoiceJob::dispatch($order->id);
    }

    return view('success.success', [
        'product' => $product,
        'orderId' => $orderId,
        'order' => $order,
    ]);
})->middleware('auth')->name('checkout.success');

/* KERANJANG */
Route::get('/keranjang', [WebCartController::class, 'index'])->name('cart');
Route::post('/keranjang/items', [WebCartController::class, 'store'])->middleware('auth')->name('cart.items.store');
Route::patch('/keranjang/items/{item}', [WebCartController::class, 'update'])->middleware('auth')->name('cart.items.update');
Route::delete('/keranjang/items/{item}', [WebCartController::class, 'destroy'])->middleware('auth')->name('cart.items.destroy');

Route::get('/checkout-cart', [CartCheckoutController::class, 'checkout'])
    ->middleware('auth')
    ->name('checkout.cart');
Route::post('/checkout-cart/payment', [CartCheckoutController::class, 'storePayment'])
    ->middleware('auth')
    ->name('checkout.cart.payment.store');
Route::get('/checkout-cart/payment', [CartCheckoutController::class, 'payment'])
    ->middleware('auth')
    ->name('checkout.cart.payment');
Route::get('/checkout-cart/midtrans-token', [CartCheckoutController::class, 'midtransToken'])
    ->middleware('auth')
    ->name('checkout.cart.midtrans');

Route::get('/checkout-cart/success', function () {
    $orderId = request('orderId', 'NC-CART-'.date('ymd').'-'.substr(uniqid(), -5));
    $method = request('method');
    $order = \App\Models\Order::query()
        ->where('order_number', $orderId)
        ->where('user_id', Auth::id())
        ->with(['items.product', 'deliverySchedule', 'payments'])
        ->first();

    if ($order && $order->payment_status !== 'paid') {
        $order->deductStockIfNeeded();
        $order->ensureInvoiceData();
        $order->update(['payment_status' => 'paid']);
        if (! Payment::query()->where('order_id', $order->id)->where('status', 'paid')->exists()) {
            Payment::query()->create([
                'order_id' => $order->id,
                'provider' => 'midtrans',
                'method' => $method !== 'all' ? $method : null,
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        }
        \App\Jobs\SendInvoiceJob::dispatch($order->id);
    }

    return view('success.success-cart', [
        'orderId' => $orderId,
        'order' => $order,
    ]);
})->middleware('auth')->name('checkout.cart.success');

/* DAFTAR NEGOSIASI (SEMUA PRODUK) */
Route::get('/negosiasi', function () {
    $productModels = Product::query()
        ->where('is_active', true)
        ->get();

    $products = $productModels->mapWithKeys(function (Product $product) {
        $image = $product->image;
        $imageUrl = $image
            ? (str_starts_with($image, 'products/')
                ? asset('storage/'.$image)
                : asset('assets/'.$image))
            : asset('assets/ternakayam.jpg');

        return [$product->id => [
            'name' => $product->name,
            'image' => $image,
            'image_url' => $imageUrl,
            'supplier' => $product->supplier,
            'grade' => $product->grade ?? '-',
            'unit' => $product->unit,
            'price_min' => $product->price_min,
            'price_max' => $product->price_max,
        ]];
    })->all();

    $offersByProduct = NegotiationOffer::query()
        ->with('user')
        ->whereIn('product_id', $productModels->pluck('id'))
        ->latest('id')
        ->get()
        ->groupBy('product_id')
        ->map(function ($offers) {
            return $offers->take(4)->map(function (NegotiationOffer $offer) {
                return [
                    'user' => $offer->user?->name ?? 'User',
                    'price' => $offer->price,
                    'qty' => $offer->qty,
                    'time' => $offer->created_at?->diffForHumans() ?? '-',
                    'status' => $offer->status,
                    'channel' => $offer->channel,
                ];
            })->values()->all();
        })->all();

    return view('negotiation.negotiations', compact('products', 'offersByProduct'));
})->name('negosiasi.list');
