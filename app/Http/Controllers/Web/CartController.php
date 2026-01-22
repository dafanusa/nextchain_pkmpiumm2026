<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartItemStoreRequest;
use App\Http\Requests\CartItemUpdateRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(): View
    {
        $cartItems = [];
        $cartCount = 0;
        $orderHistory = collect();

        if (Auth::check()) {
            $cart = $this->getOrCreateCart(Auth::user()->id);
            $items = $cart->items()->with('product')->get();
            $cartItems = $items->map(function (CartItem $item) {
                $product = $item->product;
                $image = $product?->image;
                $imageUrl = $image
                    ? (str_starts_with($image, 'products/')
                        ? asset('storage/'.$image)
                        : asset('assets/'.$image))
                    : asset('assets/ternakayam.jpg');

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
            })->values();
            $cartCount = $items->sum('qty');
            $orderHistory = Order::query()
                ->with('items.product')
                ->where('user_id', Auth::id())
                ->latest('id')
                ->take(5)
                ->get();
        }

        return view('cart.cart', compact('cartItems', 'cartCount', 'orderHistory'));
    }

    public function store(CartItemStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $product = Product::findOrFail($validated['product_id']);
        $qty = $validated['qty'] ?? 1;

        $cart = $this->getOrCreateCart($request->user()->id);
        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->qty += $qty;
            $item->price = $product->price_min;
            $item->save();
        } else {
            $item = $cart->items()->create([
                'product_id' => $product->id,
                'qty' => $qty,
                'price' => $product->price_min,
                'selected' => true,
            ]);
        }

        $count = $cart->items()->sum('qty');

        return response()->json([
            'message' => 'Produk ditambahkan ke keranjang.',
            'count' => $count,
        ]);
    }

    public function update(CartItemUpdateRequest $request, CartItem $item): JsonResponse
    {
        $this->authorizeItem($request->user()->id, $item);
        $validated = $request->validated();

        $item->fill(array_filter($validated, fn ($value) => $value !== null));
        $item->save();

        return response()->json(['message' => 'Keranjang diperbarui.']);
    }

    public function destroy(CartItemUpdateRequest $request, CartItem $item): JsonResponse
    {
        $this->authorizeItem($request->user()->id, $item);
        $item->delete();

        return response()->json(['message' => 'Item dihapus.']);
    }

    private function getOrCreateCart(int $userId): Cart
    {
        return Cart::firstOrCreate(
            ['user_id' => $userId, 'status' => 'active'],
            ['status' => 'active']
        );
    }

    private function authorizeItem(int $userId, CartItem $item): void
    {
        if ($item->cart->user_id !== $userId) {
            abort(403);
        }
    }
}
