<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Nota {{ $order->invoice_uid }}</title>
</head>
<body style="font-family: Arial, sans-serif; color: #0b1b32; line-height: 1.6;">
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
</body>
</html>
