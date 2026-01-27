<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Pengeluaran</title>
    <style>
        @page {
            margin: 18px;
        }
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            color: #0b1b32;
            font-size: 11px;
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
            left: 12%;
            right: 12%;
            bottom: 0;
            height: 3px;
            border-radius: 999px;
            background: linear-gradient(90deg, rgba(15, 61, 145, 0) 0%, rgba(15, 61, 145, 0.6) 50%, rgba(15, 61, 145, 0) 100%);
        }
        .title {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
            color: #0f3d91;
        }
        .sub {
            color: #4b5563;
            margin: 4px 0 0;
            font-size: 11px;
        }
        .meta {
            margin-top: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 10px 12px;
            background: #fafbff;
        }
        .meta strong {
            color: #0f3d91;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        th, td {
            padding: 8px 6px;
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
            margin-top: 10px;
            width: 100%;
        }
        .totals td {
            padding: 4px 0;
        }
        .grand {
            font-weight: 700;
            font-size: 13px;
            color: #0f3d91;
        }
        .footer {
            margin-top: 12px;
            font-size: 10px;
            color: #6b7280;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-title">
            <p class="title">Laporan Pengeluaran</p>
        </div>
        <p class="sub">UD. Ade Saputra Farm</p>
    </div>

    <div class="meta">
        <div>Periode: <strong>{{ $dateFrom ?? '-' }}</strong> - <strong>{{ $dateTo ?? '-' }}</strong></div>
        <div>Kelompok: <strong>{{ strtoupper($groupBy) }}</strong></div>
        <div>Total Pengeluaran: <strong>Rp {{ number_format($summaryTotal) }}</strong></div>
        <div>Dibuat: <strong>{{ now('Asia/Jakarta')->format('d M Y H:i') }}</strong></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Catatan</th>
                <th class="right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenses as $index => $expense)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $expense->expense_date?->format('d M Y') }}</td>
                    <td>{{ $expense->category }}</td>
                    <td>{{ $expense->description ?? '-' }}</td>
                    <td class="right">Rp {{ number_format($expense->amount) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td>Total Pengeluaran</td>
            <td class="right grand">Rp {{ number_format($summaryTotal) }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Periode</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($grouped as $row)
                <tr>
                    <td>{{ $row['label'] }}</td>
                    <td class="right">Rp {{ number_format($row['total']) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Laporan pengeluaran otomatis dari sistem NEXTCHAIN.
    </div>
</body>
</html>
