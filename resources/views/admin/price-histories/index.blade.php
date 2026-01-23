@extends('admin.layout')

@section('title', 'Riwayat Harga')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-lg font-semibold">Riwayat Harga</h2>
            <p class="text-sm text-[var(--muted)]">Pantau histori harga harian/mingguan tiap produk.</p>
        </div>
    </div>

    <form method="get" action="{{ route('admin.price-histories.index') }}" class="mb-6 flex flex-wrap items-end gap-3">
        <div class="min-w-[240px]">
            <label for="productSelect" class="text-xs font-semibold text-[var(--muted)]">Pilih Produk</label>
            <select id="productSelect" name="product_id"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm focus:border-[var(--brand)] focus:outline-none">
                <option value="">Pilih produk</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" @selected($selectedProduct?->id === $product->id)>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit"
                class="inline-flex items-center justify-center rounded-full bg-[var(--brand)] px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[var(--brand-dark)] transition">
            Tampilkan
        </button>
    </form>

    @if (! $selectedProduct)
        <div class="bg-white rounded-3xl border border-slate-200 p-6 text-sm text-[var(--muted)] shadow-sm">
            Silakan pilih produk untuk melihat grafik dan riwayat harga.
        </div>
    @else
        <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-xs text-[var(--muted)]">Grafik harga</p>
                        <h3 class="text-lg font-semibold">{{ $selectedProduct->name }}</h3>
                    </div>
                    <div class="inline-flex items-center gap-2 rounded-full bg-slate-100 p-1">
                        <button type="button"
                                class="price-range-btn px-3 py-1.5 rounded-full text-xs font-semibold bg-white text-[var(--brand)] shadow-sm"
                                data-range="daily">
                            Harian
                        </button>
                        <button type="button"
                                class="price-range-btn px-3 py-1.5 rounded-full text-xs font-semibold text-[var(--muted)]"
                                data-range="weekly">
                            Mingguan
                        </button>
                    </div>
                </div>
                <div class="mt-4">
                    <canvas id="priceChart" height="160"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <h3 class="text-lg font-semibold">Ringkasan</h3>
                <div class="mt-4 space-y-3 text-sm text-[var(--muted)]">
                    <p><span class="font-semibold text-[var(--ink)]">Harga Min Saat Ini:</span>
                        Rp {{ number_format($selectedProduct->price_min) }}</p>
                    <p><span class="font-semibold text-[var(--ink)]">Harga Max Saat Ini:</span>
                        Rp {{ number_format($selectedProduct->price_max) }}</p>
                    <p><span class="font-semibold text-[var(--ink)]">Update Terakhir:</span>
                        {{ $selectedProduct->priceHistories->last()?->price_date?->format('d M Y') ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="mt-6 bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[640px] w-full text-sm">
                    <thead class="bg-slate-50 text-[var(--muted)]">
                        <tr>
                            <th class="text-left px-4 py-3">Tanggal</th>
                            <th class="text-left px-4 py-3">Harga Min</th>
                            <th class="text-left px-4 py-3">Harga Max</th>
                            <th class="text-left px-4 py-3">Sumber</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($selectedProduct->priceHistories as $history)
                            <tr class="border-t border-slate-100">
                                <td class="px-4 py-3 text-[var(--muted)]">{{ $history->price_date->format('d M Y') }}</td>
                                <td class="px-4 py-3 text-[var(--muted)]">Rp {{ number_format($history->price_min) }}</td>
                                <td class="px-4 py-3 text-[var(--muted)]">Rp {{ number_format($history->price_max) }}</td>
                                <td class="px-4 py-3 text-[var(--muted)]">{{ $history->source }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-[var(--muted)]">Belum ada riwayat harga.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const priceData = {
            daily: {
                labels: @json($dailyLabels ?? []),
                min: @json($dailyMin ?? []),
                max: @json($dailyMax ?? []),
            },
            weekly: {
                labels: @json($weeklyLabels ?? []),
                min: @json($weeklyMin ?? []),
                max: @json($weeklyMax ?? []),
            },
        };

        const chartCanvas = document.getElementById('priceChart');
        let priceChart = null;

        function renderChart(range) {
            if (!chartCanvas) return;

            const dataSet = priceData[range];
            const chartConfig = {
                type: 'line',
                data: {
                    labels: dataSet.labels,
                    datasets: [
                        {
                            label: 'Harga Min',
                            data: dataSet.min,
                            borderColor: '#0f3d91',
                            backgroundColor: 'rgba(15, 61, 145, 0.15)',
                            tension: 0.35,
                            spanGaps: true,
                        },
                        {
                            label: 'Harga Max',
                            data: dataSet.max,
                            borderColor: '#f59e0b',
                            backgroundColor: 'rgba(245, 158, 11, 0.12)',
                            tension: 0.35,
                            spanGaps: true,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                boxWidth: 10,
                                usePointStyle: true,
                                pointStyle: 'circle',
                            },
                        },
                    },
                    scales: {
                        y: {
                            ticks: {
                                callback: (value) => 'Rp ' + Number(value).toLocaleString('id-ID'),
                            },
                        },
                    },
                },
            };

            if (priceChart) {
                priceChart.destroy();
            }
            priceChart = new Chart(chartCanvas, chartConfig);
        }

        const rangeButtons = Array.from(document.querySelectorAll('.price-range-btn'));
        rangeButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                rangeButtons.forEach((button) => {
                    button.classList.remove('bg-white', 'text-[var(--brand)]', 'shadow-sm');
                    button.classList.add('text-[var(--muted)]');
                });
                btn.classList.add('bg-white', 'text-[var(--brand)]', 'shadow-sm');
                btn.classList.remove('text-[var(--muted)]');
                renderChart(btn.dataset.range);
            });
        });

        renderChart('daily');
    </script>
@endsection

