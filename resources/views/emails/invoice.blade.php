<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Nota {{ $order->invoice_uid }}</title>
</head>
<body style="font-family: Arial, sans-serif; color: #0b1b32; line-height: 1.6;">
    <div id="top"></div>
    <h2 style="margin-bottom: 4px;">{{ $businessName }}</h2>
    <p style="margin-top: 0; color: #4b5563;">Nota pembelian kamu sudah siap.</p>

    <p>
        UID Nota: <strong>{{ $order->invoice_uid }}</strong><br>
        Order: <strong>{{ $order->order_number }}</strong>
    </p>

    <p>
        Kamu bisa mengunduh nota melalui lampiran email ini atau lewat link berikut:<br>
        <a href="{{ $publicUrl }}">{{ $publicUrl }}</a>
    </p>

    <p>Terima kasih sudah berbelanja di {{ $businessName }}.</p>
    <a href="#top" class="lg:hidden fixed bottom-6 right-6 z-40 inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#0f3d91] text-white shadow-lg shadow-blue-900/30 hover:bg-[#0a2d6c] transition" aria-label="Kembali ke atas">
        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M6 14l6-6 6 6" />
        </svg>
    </a></body>
</html>









