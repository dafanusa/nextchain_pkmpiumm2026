<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProductPriceRequest;
use App\Models\PriceHistory;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::orderByDesc('id')->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    public function price(): View
    {
        $products = Product::orderByDesc('id')->paginate(20);

        return view('admin.products.price', compact('products'));
    }

    public function updatePrice(UpdateProductPriceRequest $request, Product $product): RedirectResponse
    {
        $validated = $request->validated();

        $product->update([
            'price_min' => $validated['price_min'],
            'price_max' => $validated['price_max'],
        ]);

        $today = now('Asia/Jakarta')->toDateString();
        PriceHistory::query()->updateOrCreate(
            [
                'product_id' => $product->id,
                'price_date' => $today,
            ],
            [
                'price_min' => $product->price_min,
                'price_max' => $product->price_max,
                'source' => 'admin',
            ]
        );

        return redirect()->route('admin.products.price')->with('success', 'Harga produk diperbarui.');
    }

    public function create()
    {
        return view('admin.products.form', ['product' => new Product]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'supplier' => ['required', 'string', 'max:255'],
            'grade' => ['nullable', 'string', 'max:40'],
            'unit' => ['required', 'string', 'max:20'],
            'price_min' => ['required', 'integer', 'min:0'],
            'price_max' => ['required', 'integer', 'min:0'],
            'moq' => ['required', 'integer', 'min:1'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'description' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product = Product::create($validated);
        $today = now('Asia/Jakarta')->toDateString();
        PriceHistory::query()->updateOrCreate(
            [
                'product_id' => $product->id,
                'price_date' => $today,
            ],
            [
                'price_min' => $product->price_min,
                'price_max' => $product->price_max,
                'source' => 'admin',
            ]
        );

        return redirect()->route('admin.products.index')->with('success', 'Produk dibuat.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'supplier' => ['required', 'string', 'max:255'],
            'grade' => ['nullable', 'string', 'max:40'],
            'unit' => ['required', 'string', 'max:20'],
            'price_min' => ['required', 'integer', 'min:0'],
            'price_max' => ['required', 'integer', 'min:0'],
            'moq' => ['required', 'integer', 'min:1'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'description' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);
        $today = now('Asia/Jakarta')->toDateString();
        PriceHistory::query()->updateOrCreate(
            [
                'product_id' => $product->id,
                'price_date' => $today,
            ],
            [
                'price_min' => $product->price_min,
                'price_max' => $product->price_max,
                'source' => 'admin',
            ]
        );

        return redirect()->route('admin.products.index')->with('success', 'Produk diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk dihapus.');
    }
}
