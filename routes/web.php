<?php

use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NegotiationOfferController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\CartCheckoutController;
use App\Http\Controllers\Web\CartController as WebCartController;
use App\Http\Controllers\Web\NegotiationController as WebNegotiationController;
use App\Http\Controllers\Web\TestimonialWebController;
use App\Models\NegotiationOffer;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/* DATA PRODUK (SIMULASI) */
$products = [
    1 => [
        'name' => 'Telur Ayam Ras Grade A',
        'image' => 'ternakayam.jpg',
        'images' => [
            'ternakayam.jpg',
            'ternakayam1.jpg',
            'ternakayam2.jpg',
            'ternakayam3.jpg',
        ],
        'supplier' => 'UD. AdeSaputra Farm',
        'grade' => 'A',
        'unit' => 'kg',
        'price_min' => 26000,
        'price_max' => 28000,
        'moq' => 50,
        'stock' => 1200,
        'description' => 'Telur ayam ras grade A dengan ukuran seragam, cocok untuk retail dan kebutuhan harian.',
    ],
    2 => [
        'name' => 'Telur Ayam Ras Grade B',
        'image' => 'ternakayam1.jpg',
        'images' => [
            'ternakayam1.jpg',
            'ternakayam.jpg',
            'ternakayam2.jpg',
            'ternakayam3.jpg',
        ],
        'supplier' => 'UD. AdeSaputra Farm',
        'grade' => 'B',
        'unit' => 'kg',
        'price_min' => 23000,
        'price_max' => 25000,
        'moq' => 50,
        'stock' => 980,
        'description' => 'Grade B untuk kebutuhan volume besar dengan harga lebih efisien.',
    ],
    3 => [
        'name' => 'Telur Omega',
        'image' => 'ternakayam2.jpg',
        'images' => [
            'ternakayam2.jpg',
            'ternakayam3.jpg',
            'ternakayam.jpg',
            'ternakayam1.jpg',
        ],
        'supplier' => 'UD. AdeSaputra Farm',
        'grade' => 'Premium',
        'unit' => 'kg',
        'price_min' => 30000,
        'price_max' => 33000,
        'moq' => 30,
        'stock' => 620,
        'description' => 'Telur premium dengan nutrisi tinggi untuk segmen kesehatan dan horeka.',
    ],
    4 => [
        'name' => 'Paket Telur 1 Peti',
        'image' => 'ternakayam3.jpg',
        'images' => [
            'ternakayam3.jpg',
            'ternakayam2.jpg',
            'ternakayam1.jpg',
            'ternakayam.jpg',
        ],
        'supplier' => 'UD. AdeSaputra Farm',
        'grade' => 'Peti',
        'unit' => 'peti',
        'price_min' => 900000,
        'price_max' => 950000,
        'moq' => 1,
        'stock' => 140,
        'description' => 'Paket peti untuk distribusi cepat dan volume besar.',
    ],
];

/* HOME */
Route::get('/', [HomeController::class, 'index'])->name('home');

/* AUTH (WEB) */
Route::get('/register', [WebAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [WebAuthController::class, 'register'])->middleware('throttle:register');
Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [WebAuthController::class, 'login'])->middleware('throttle:login');
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

Route::post('/testimoni', [TestimonialWebController::class, 'store'])
    ->middleware('auth')
    ->name('testimonials.store');

/* ADMIN */
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('users', UserController::class)->names('admin.users')->except(['show']);
    Route::resource('products', ProductController::class)->names('admin.products')->except(['show']);
    Route::resource('offers', NegotiationOfferController::class)->names('admin.offers')->only(['index', 'edit', 'update', 'destroy']);
    Route::patch('offers/{offer}/approve', [NegotiationOfferController::class, 'approve'])->name('admin.offers.approve');
    Route::patch('offers/{offer}/reject', [NegotiationOfferController::class, 'reject'])->name('admin.offers.reject');
    Route::resource('orders', OrderController::class)->names('admin.orders')->only(['index', 'show', 'update']);
    Route::resource('payments', PaymentController::class)->names('admin.payments')->only(['index', 'edit', 'update']);
    Route::resource('testimonials', TestimonialController::class)->names('admin.testimonials')->only(['index', 'edit', 'update', 'destroy']);
    Route::patch('testimonials/{testimonial}/approve', [TestimonialController::class, 'approve'])->name('admin.testimonials.approve');
    Route::resource('carts', CartController::class)->names('admin.carts')->only(['index', 'show', 'destroy']);
});

// Halaman lokasi/testimoni/galeri disatukan di home.
// Halaman tentang disatukan di home.

/* PRODUK */
Route::get('/produk', function () use ($products) {
    return view('product', compact('products'));
})->name('produk');

/* DETAIL */
Route::get('/produk/{id}', function ($id) use ($products) {
    abort_if(! isset($products[$id]), 404);
    $product = $products[$id];

    return view('detail', compact('product'));
})->name('produk.detail');

/* NEGOSIASI */
Route::get('/produk/{id}/negosiasi', function ($id) use ($products) {
    abort_if(! isset($products[$id]), 404);
    $product = $products[$id];
    $offers = \App\Models\NegotiationOffer::with('user')
        ->where('product_id', $id)
        ->latest('id')
        ->take(12)
        ->get();

    $acceptedOffer = \App\Models\NegotiationOffer::with('user')
        ->where('product_id', $id)
        ->where('status', 'accepted')
        ->latest('accepted_at')
        ->first();

    $userOffer = auth()->check()
        ? \App\Models\NegotiationOffer::query()
            ->where('product_id', $id)
            ->where('user_id', auth()->id())
            ->latest('id')
            ->first()
        : null;

    $messages = $userOffer
        ? $userOffer->messages()->with('user')->oldest('id')->get()
        : collect();

    return view('negotiation', compact('product', 'offers', 'acceptedOffer', 'userOffer', 'messages'));
})->name('produk.negosiasi');
Route::post('/produk/{id}/negosiasi', [WebNegotiationController::class, 'store'])
    ->middleware('auth')
    ->name('produk.negosiasi.store');
Route::post('/produk/{id}/negosiasi/pesan', [WebNegotiationController::class, 'storeMessage'])
    ->middleware('auth')
    ->name('produk.negosiasi.message');

/* CHECKOUT (SIMULASI FLOW) */
Route::get('/checkout/{id}', function ($id) use ($products) {
    abort_if(! isset($products[$id]), 404);
    $product = $products[$id];
    $qty = max($product['moq'], (int) request('qty', $product['moq']));
    $unitPrice = (int) round(($product['price_min'] + $product['price_max']) / 2);
    $subtotal = $unitPrice * $qty;
    $shipping = 25000;
    $total = $subtotal + $shipping;
    $orderId = 'NC-'.date('ymd').'-'.str_pad((string) $id, 3, '0', STR_PAD_LEFT);

    return view('checkout', compact('product', 'qty', 'unitPrice', 'subtotal', 'shipping', 'total', 'orderId'));
})->middleware('auth')->name('checkout');

Route::get('/checkout/{id}/payment', function ($id) use ($products) {
    abort_if(! isset($products[$id]), 404);
    $product = $products[$id];
    $qty = max($product['moq'], (int) request('qty', $product['moq']));
    $unitPrice = (int) round(($product['price_min'] + $product['price_max']) / 2);
    $subtotal = $unitPrice * $qty;
    $shipping = 25000;
    $total = $subtotal + $shipping;
    $orderId = 'NC-'.date('ymd').'-'.str_pad((string) $id, 3, '0', STR_PAD_LEFT);
    $midtransClientKey = env('MIDTRANS_CLIENT_KEY');
    $buyer = [
        'name' => request('name', ''),
        'phone' => request('phone', ''),
        'address' => request('address', ''),
        'shipping_method' => request('shipping_method', ''),
        'shipping_date' => request('shipping_date', ''),
        'shipping_time' => request('shipping_time', ''),
        'note' => request('note', ''),
    ];

    if (auth()->check()) {
        $order = \App\Models\Order::firstOrCreate(
            ['order_number' => $orderId],
            [
                'user_id' => auth()->id(),
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'subtotal' => $subtotal,
                'shipping_fee' => $shipping,
                'total' => $total,
                'buyer_name' => $buyer['name'] ?: auth()->user()->name,
                'buyer_phone' => $buyer['phone'] ?: '-',
                'buyer_address' => $buyer['address'] ?: '-',
                'shipping_method' => $buyer['shipping_method'] ?: null,
                'shipping_date' => $buyer['shipping_date'] ?: null,
                'shipping_time' => $buyer['shipping_time'] ?: null,
                'note' => $buyer['note'] ?: null,
            ]
        );

        if (! $order->items()->where('product_id', $id)->exists()) {
            $order->items()->create([
                'product_id' => $id,
                'unit' => $product['unit'],
                'price' => $unitPrice,
                'qty' => $qty,
                'line_total' => $subtotal,
            ]);
        }
    }

    return view('payment', compact('product', 'qty', 'unitPrice', 'subtotal', 'shipping', 'total', 'orderId', 'midtransClientKey', 'buyer'));
})->middleware('auth')->name('checkout.payment');

Route::get('/checkout/{id}/midtrans-token', function ($id) use ($products) {
    abort_if(! isset($products[$id]), 404);

    $product = $products[$id];
    $qty = max($product['moq'], (int) request('qty', $product['moq']));
    $unitPrice = (int) round(($product['price_min'] + $product['price_max']) / 2);
    $subtotal = $unitPrice * $qty;
    $shipping = 25000;
    $total = $subtotal + $shipping;
    $orderId = 'NC-'.date('ymd').'-'.str_pad((string) $id, 3, '0', STR_PAD_LEFT).'-'.substr(uniqid(), -5);

    $payload = [
        'transaction_details' => [
            'order_id' => $orderId,
            'gross_amount' => $total,
        ],
        'item_details' => [
            [
                'id' => (string) $id,
                'price' => $unitPrice,
                'quantity' => $qty,
                'name' => $product['name'],
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

    $serverKey = env('MIDTRANS_SERVER_KEY');
    if (empty($serverKey)) {
        return response()->json(['error' => 'MIDTRANS_SERVER_KEY belum diatur.'], 500);
    }

    $ch = curl_init('https://app.sandbox.midtrans.com/snap/v1/transactions');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Basic '.base64_encode($serverKey.':'),
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 201 && $httpCode !== 200) {
        return response()->json(['error' => 'Gagal membuat token Midtrans.', 'detail' => $response], 500);
    }

    $data = json_decode($response, true);
    if (! isset($data['token'])) {
        return response()->json(['error' => 'Token Midtrans tidak ditemukan.', 'detail' => $data], 500);
    }

    return response()->json(['token' => $data['token']]);
})->middleware('auth')->name('checkout.midtrans');

Route::get('/checkout/{id}/success', function ($id) use ($products) {
    abort_if(! isset($products[$id]), 404);
    $product = $products[$id];
    $orderId = 'NC-'.date('ymd').'-'.str_pad((string) $id, 3, '0', STR_PAD_LEFT);

    return view('success', compact('product', 'orderId'));
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

    return view('success-cart', compact('orderId'));
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

    return view('negotiations', compact('products', 'offersByProduct'));
})->name('negosiasi.list');
