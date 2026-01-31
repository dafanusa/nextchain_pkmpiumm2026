<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Nota {{ $order->invoice_uid }}</title>
    <style>
        @page {
            margin: 16px;
        }
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            color: #0b1b32;
            font-size: 12px;
            line-height: 1.5;
            margin: 0;
            background: #ffffff;
        }
        .header {
            text-align: center;
            margin-bottom: 16px;
        }
        .header-title {
            display: inline-block;
            position: relative;
            padding-bottom: 4px;
        }
        .header-title::after {
            content: "";
            position: absolute;
            left: 18%;
            right: 18%;
            bottom: 0;
            height: 3px;
            border-radius: 999px;
            background: linear-gradient(90deg, rgba(15, 61, 145, 0) 0%, rgba(15, 61, 145, 0.6) 50%, rgba(15, 61, 145, 0) 100%);
        }
        .header-sub {
            margin-top: 4px;
            color: #4b5563;
            font-size: 11px;
        }
        .header-chip {
            margin-top: 8px;
        }
        .header-lines {
            margin-top: 6px;
        }
        .title {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
            color: #0f3d91;
        }
        .sub {
            color: #4b5563;
            margin: 2px 0 0;
            font-size: 11px;
        }
        .meta-table {
            width: 100%;
            margin-top: 14px;
            border-collapse: separate;
            border-spacing: 10px 0;
        }
        .meta-table td {
            vertical-align: top;
        }
        .box {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 8px 10px;
            background: #fafbff;
        }
        .box h4 {
            margin: 0 0 6px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.22em;
            color: #64748b;
        }
        .badge {
            display: inline-flex;
            padding: 4px 10px;
            border-radius: 999px;
            background: #e7f0ff;
            color: #0f3d91;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.08em;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        th, td {
            padding: 9px 8px;
            border-bottom: 1px solid #e5e7eb;
        }
        th {
            text-align: left;
            background: #f8fafc;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: #64748b;
        }
        .right {
            text-align: right;
        }
        .totals {
            margin-top: 8px;
            width: 100%;
        }
        .totals td {
            padding: 4px 0;
        }
        .grand {
            font-weight: 700;
            font-size: 14px;
            color: #0f3d91;
        }
        .divider {
            border-top: 1px solid #e5e7eb;
            margin: 10px 0 0;
        }
        .no-break {
            page-break-inside: avoid;
        }
        .no-break, .no-break table, .no-break tr, .no-break td {
            page-break-inside: avoid;
        }
        .footer {
            margin-top: 14px;
            font-size: 11px;
            color: #6b7280;
            text-align: center;
        }
        .table-shell {
            width: 96%;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    @include('loading-overlay')
    <div id="top"></div>
        <div class="header">
            <div class="header-title">
                <p class="title">{{ $businessName }}</p>
            </div>
            <div class="header-sub">Nota Pembelian</div>
            <div class="header-chip">
                <span class="badge">INVOICE</span>
            </div>
        </div>

    <table class="meta-table no-break">
            <tr>
                <td style="width: 45%;">
                    <div class="box" style="min-height: 84px;">
                        <h4>Pelanggan</h4>
                        <div><strong>{{ $order->buyer_name }}</strong></div>
                        <div>{{ $order->buyer_phone }}</div>
                        <div>{{ $order->buyer_address }}</div>
                    </div>
                </td>
                <td style="width: 55%;">
                    <div class="box" style="min-height: 84px;">
                        <h4>Invoice</h4>
                        <div>UID: {{ $order->invoice_uid }}</div>
                        <div>Order: {{ $order->order_number }}</div>
                        <div>Tanggal: {{ $order->created_at?->format('d M Y, H:i') }}</div>
                    </div>
                </td>
            </tr>
        </table>

    <div class="table-shell">
        <table class="no-break">
            <thead>
            <tr>
                <th>Produk</th>
                <th class="right">Qty</th>
                <th class="right">Harga</th>
                <th class="right">Subtotal</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($order->items->take(10) as $item)
                <tr>
                    <td>
                        {{ $item->product?->name ?? 'Produk' }}
                    </td>
                    <td class="right">{{ $item->qty }} {{ $item->unit }}</td>
                    <td class="right">Rp {{ number_format($item->price) }}</td>
                    <td class="right">Rp {{ number_format($item->line_total) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @if ($order->items->count() > 10)
        <div class="sub" style="margin-top: 6px;">
            +{{ $order->items->count() - 10 }} item lainnya ada di halaman berikutnya.
        </div>
    @endif

    <div class="no-break">
        <table class="totals">
            <tr>
                <td>Subtotal</td>
                <td class="right">Rp {{ number_format($order->subtotal) }}</td>
            </tr>
            <tr>
                <td>Ongkir</td>
                <td class="right">Rp {{ number_format($order->shipping_fee) }}</td>
            </tr>
            <tr>
                <td class="grand">Total</td>
                <td class="right grand">Rp {{ number_format($order->total) }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <table class="meta-table" style="margin-top: 8px;">
            <tr>
                <td style="width: 50%;">
                    <div class="box">
                        <h4>Pengiriman</h4>
                        <div>Metode: {{ $order->shipping_method ?? '-' }}</div>
                        <div>Jadwal: {{ $order->shipping_date?->format('d M Y') ?? '-' }} {{ $order->shipping_time ?? '' }}</div>
                        @if ($order->deliverySchedule)
                            <div>Tujuan: {{ $order->deliverySchedule->destination }}</div>
                        @endif
                    </div>
                </td>
                <td style="width: 50%;">
                    <div class="box">
                        <h4>Pembayaran</h4>
                        @php
                            $payment = $order->payments->sortByDesc('id')->first();
                        @endphp
                        <div>Metode: {{ $payment?->method ?? '-' }}</div>
                        <div>Status: {{ $order->payment_status }}</div>
                    </div>
                </td>
            </tr>
        </table>

        <div class="footer">
            Terima kasih sudah berbelanja di {{ $businessName }}.
        </div>
    </div>
    <a href="#top" class="lg:hidden fixed bottom-6 right-6 z-40 inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#0f3d91] text-white shadow-lg shadow-blue-900/30 hover:bg-[#0a2d6c] transition" aria-label="Kembali ke atas">
        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M6 14l6-6 6 6" />
        </svg>
    </a></body>
</html>









