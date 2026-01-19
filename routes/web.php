<?php

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
            'ternakayam3.jpg'
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
            'ternakayam3.jpg'
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
            'ternakayam1.jpg'
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
            'ternakayam.jpg'
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
Route::get('/', function () {
    return view('home');
})->name('home');

// Halaman lokasi/testimoni/galeri disatukan di home.
// Halaman tentang disatukan di home.

/* PRODUK */
Route::get('/produk', function () use ($products) {
    return view('product', compact('products'));
})->name('produk');

/* DETAIL */
Route::get('/produk/{id}', function ($id) use ($products) {
    abort_if(!isset($products[$id]), 404);
    $product = $products[$id];
    return view('detail', compact('product'));
})->name('produk.detail');

/* NEGOSIASI */
Route::get('/produk/{id}/negosiasi', function ($id) use ($products) {
    abort_if(!isset($products[$id]), 404);
    $product = $products[$id];
    return view('negotiation', compact('product'));
})->name('produk.negosiasi');

/* CHECKOUT (SIMULASI FLOW) */
Route::get('/checkout/{id}', function ($id) use ($products) {
    abort_if(!isset($products[$id]), 404);
    $product = $products[$id];
    $qty = max($product['moq'], (int) request('qty', $product['moq']));
    $unitPrice = (int) round(($product['price_min'] + $product['price_max']) / 2);
    $subtotal = $unitPrice * $qty;
    $shipping = 25000;
    $total = $subtotal + $shipping;
    $orderId = 'NC-' . date('ymd') . '-' . str_pad((string) $id, 3, '0', STR_PAD_LEFT);

    return view('checkout', compact('product', 'qty', 'unitPrice', 'subtotal', 'shipping', 'total', 'orderId'));
})->name('checkout');

Route::get('/checkout/{id}/payment', function ($id) use ($products) {
    abort_if(!isset($products[$id]), 404);
    $product = $products[$id];
    $qty = max($product['moq'], (int) request('qty', $product['moq']));
    $unitPrice = (int) round(($product['price_min'] + $product['price_max']) / 2);
    $subtotal = $unitPrice * $qty;
    $shipping = 25000;
    $total = $subtotal + $shipping;
    $orderId = 'NC-' . date('ymd') . '-' . str_pad((string) $id, 3, '0', STR_PAD_LEFT);
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

    return view('payment', compact('product', 'qty', 'unitPrice', 'subtotal', 'shipping', 'total', 'orderId', 'midtransClientKey', 'buyer'));
})->name('checkout.payment');

Route::get('/checkout/{id}/midtrans-token', function ($id) use ($products) {
    abort_if(!isset($products[$id]), 404);

    $product = $products[$id];
    $qty = max($product['moq'], (int) request('qty', $product['moq']));
    $unitPrice = (int) round(($product['price_min'] + $product['price_max']) / 2);
    $subtotal = $unitPrice * $qty;
    $shipping = 25000;
    $total = $subtotal + $shipping;
    $orderId = 'NC-' . date('ymd') . '-' . str_pad((string) $id, 3, '0', STR_PAD_LEFT) . '-' . substr(uniqid(), -5);

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
    if (!empty($method) && $method !== 'all') {
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
        'Authorization: Basic ' . base64_encode($serverKey . ':'),
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
    if (!isset($data['token'])) {
        return response()->json(['error' => 'Token Midtrans tidak ditemukan.', 'detail' => $data], 500);
    }

    return response()->json(['token' => $data['token']]);
})->name('checkout.midtrans');

Route::get('/checkout/{id}/success', function ($id) use ($products) {
    abort_if(!isset($products[$id]), 404);
    $product = $products[$id];
    $orderId = 'NC-' . date('ymd') . '-' . str_pad((string) $id, 3, '0', STR_PAD_LEFT);

    return view('success', compact('product', 'orderId'));
})->name('checkout.success');

/* KERANJANG */
Route::get('/keranjang', function () {
    return view('cart');
})->name('cart');

Route::get('/checkout-cart', function () {
    return view('checkout-cart');
})->name('checkout.cart');

Route::get('/checkout-cart/payment', function () {
    $orderId = 'NC-CART-' . date('ymd') . '-' . substr(uniqid(), -5);
    $midtransClientKey = env('MIDTRANS_CLIENT_KEY');
    return view('payment-cart', compact('orderId', 'midtransClientKey'));
})->name('checkout.cart.payment');

Route::get('/checkout-cart/midtrans-token', function () use ($products) {
    $itemsJson = request('items', '[]');
    $items = json_decode($itemsJson, true);
    if (!is_array($items)) {
        return response()->json(['error' => 'Payload item tidak valid.'], 400);
    }

    $itemDetails = [];
    $subtotal = 0;
    foreach ($items as $row) {
        $id = (int) ($row['id'] ?? 0);
        $qty = (int) ($row['qty'] ?? 0);
        if ($id <= 0 || $qty <= 0 || !isset($products[$id])) {
            continue;
        }
        $product = $products[$id];
        $unitPrice = (int) $product['price_min'];
        $subtotal += $unitPrice * $qty;
        $itemDetails[] = [
            'id' => (string) $id,
            'price' => $unitPrice,
            'quantity' => $qty,
            'name' => $product['name'],
        ];
    }

    if (empty($itemDetails)) {
        return response()->json(['error' => 'Tidak ada item valid.'], 400);
    }

    $shipping = 25000;
    $total = $subtotal + $shipping;
    $orderId = request('order_id', 'NC-CART-' . date('ymd') . '-' . substr(uniqid(), -5));
    $method = request('method');

    $itemDetails[] = [
        'id' => 'shipping',
        'price' => $shipping,
        'quantity' => 1,
        'name' => 'Ongkir',
    ];

    $payload = [
        'transaction_details' => [
            'order_id' => $orderId,
            'gross_amount' => $total,
        ],
        'item_details' => $itemDetails,
        'customer_details' => [
            'first_name' => request('name', 'Pembeli'),
            'phone' => request('phone', ''),
            'shipping_address' => [
                'address' => request('address', ''),
            ],
        ],
    ];

    if (!empty($method) && $method !== 'all') {
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
        'Authorization: Basic ' . base64_encode($serverKey . ':'),
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
    if (!isset($data['token'])) {
        return response()->json(['error' => 'Token Midtrans tidak ditemukan.', 'detail' => $data], 500);
    }

    return response()->json(['token' => $data['token']]);
})->name('checkout.cart.midtrans');

Route::get('/checkout-cart/success', function () {
    $orderId = request('orderId', 'NC-CART-' . date('ymd') . '-' . substr(uniqid(), -5));
    return view('success-cart', compact('orderId'));
})->name('checkout.cart.success');

/* DAFTAR NEGOSIASI (SEMUA PRODUK) */
Route::get('/negosiasi', function () use ($products) {
    $offersByProduct = [
        1 => [
            ['user' => 'User A', 'price' => 25500, 'qty' => 80, 'time' => '2 menit lalu'],
            ['user' => 'User B', 'price' => 26500, 'qty' => 120, 'time' => '7 menit lalu'],
        ],
        2 => [
            ['user' => 'User C', 'price' => 23500, 'qty' => 60, 'time' => '4 menit lalu'],
            ['user' => 'User D', 'price' => 24000, 'qty' => 90, 'time' => '10 menit lalu'],
        ],
        3 => [
            ['user' => 'User E', 'price' => 31000, 'qty' => 50, 'time' => '5 menit lalu'],
        ],
        4 => [
            ['user' => 'User F', 'price' => 920000, 'qty' => 2, 'time' => '8 menit lalu'],
        ],
    ];

    return view('negotiations', compact('products', 'offersByProduct'));
})->name('negosiasi.list');
