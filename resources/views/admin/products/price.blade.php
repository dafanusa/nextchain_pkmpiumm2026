@extends('admin.layout')

@section('title', 'Update Harga')

@section('content')
    <div class="mb-6">
        <h2 class="text-lg font-semibold">Update Harga Produk</h2>
        <p class="text-sm text-[var(--muted)] mt-1">Pilih produk, lalu ubah harga minimal dan maksimal.</p>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-[560px] w-full text-sm">
                <thead class="bg-slate-50 text-[var(--muted)]">
                    <tr>
                        <th class="text-left px-4 py-3">Produk</th>
                        <th class="text-left px-4 py-3">Harga Saat Ini</th>
                        <th class="text-left px-4 py-3">Update Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-12 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center text-[10px] text-slate-400">
                                        @if ($product->image)
                                            <img src="{{ str_starts_with($product->image, 'products/') ? asset('storage/' . $product->image) : asset('assets/' . $product->image) }}"
                                                 alt="{{ $product->name }}"
                                                 class="h-full w-full object-cover">
                                        @else
                                            NO IMG
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-semibold text-[var(--ink)]">{{ $product->name }}</div>
                                        <div class="text-xs text-[var(--muted)]">{{ $product->unit }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-[var(--muted)]">Rp {{ number_format($product->price_min) }} - Rp {{ number_format($product->price_max) }}</td>
                            <td class="px-4 py-3">
                                <form method="post" action="{{ route('admin.products.price.update', $product) }}" class="flex flex-wrap items-center gap-2">
                                    @csrf
                                    @method('patch')
                                    <div class="flex items-center gap-2">
                                        <input
                                            type="text"
                                            inputmode="numeric"
                                            autocomplete="off"
                                            data-price-display
                                            data-price-target="price_min_{{ $product->id }}"
                                            value="{{ number_format((int) old('price_min', $product->price_min)) }}"
                                            placeholder="cth: 2.5j / 2500000"
                                            class="w-36 rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-[var(--ink)] focus:outline-none focus:ring-2 focus:ring-blue-200"
                                        >
                                        <input type="hidden" name="price_min" id="price_min_{{ $product->id }}" value="{{ old('price_min', $product->price_min) }}">
                                        <span class="text-xs text-[var(--muted)]">-</span>
                                        <input
                                            type="text"
                                            inputmode="numeric"
                                            autocomplete="off"
                                            data-price-display
                                            data-price-target="price_max_{{ $product->id }}"
                                            value="{{ number_format((int) old('price_max', $product->price_max)) }}"
                                            placeholder="cth: 2.5j / 2500000"
                                            class="w-36 rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-[var(--ink)] focus:outline-none focus:ring-2 focus:ring-blue-200"
                                        >
                                        <input type="hidden" name="price_max" id="price_max_{{ $product->id }}" value="{{ old('price_max', $product->price_max) }}">
                                    </div>
                                    <button type="submit"
                                            class="inline-flex px-3 py-1.5 rounded-full bg-[var(--brand)] text-white text-xs font-semibold hover:bg-[var(--brand-dark)] transition">
                                        Simpan
                                    </button>
                                </form>
                                @error('price_min')
                                    <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                                @enderror
                                @error('price_max')
                                    <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-[var(--muted)]">Belum ada produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const displayInputs = Array.from(document.querySelectorAll('[data-price-display]'));
            if (displayInputs.length === 0) {
                return;
            }

            const jutaPattern = /(jt|juta|j)\s*$/i;

            const normalizeNumericPart = (value, isJuta) => {
                const stripped = value.replace(/[^0-9.]/g, '');
                const dotCount = (stripped.match(/\./g) ?? []).length;

                if (dotCount > 1) {
                    return stripped.replace(/\./g, '');
                }

                if (!isJuta && dotCount === 1) {
                    const [left, right] = stripped.split('.');
                    if ((right?.length ?? 0) === 3 && (left?.length ?? 0) >= 1) {
                        return `${left}${right}`;
                    }
                }

                return stripped;
            };

            const parseToNumber = (rawValue) => {
                const normalized = rawValue
                    .trim()
                    .toLowerCase()
                    .replace(/\s+/g, '')
                    .replace(/,/g, '.');

                if (normalized === '') {
                    return null;
                }

                const isJuta = jutaPattern.test(normalized);
                const numericCandidate = normalized.replace(jutaPattern, '');
                const numericPart = normalizeNumericPart(numericCandidate, isJuta);

                if (numericPart === '') {
                    return null;
                }

                const parsed = Number(numericPart);
                if (Number.isNaN(parsed)) {
                    return null;
                }

                const value = isJuta ? parsed * 1_000_000 : parsed;
                return Math.round(value);
            };

            const formatNumber = (value) => {
                if (value === null) {
                    return '';
                }
                return new Intl.NumberFormat('id-ID').format(value);
            };

            const syncHiddenInput = (displayInput, shouldFormatDisplay = true) => {
                const targetId = displayInput.getAttribute('data-price-target');
                if (!targetId) {
                    return;
                }
                const hiddenInput = document.getElementById(targetId);
                if (!hiddenInput) {
                    return;
                }

                const parsedNumber = parseToNumber(displayInput.value);
                if (parsedNumber === null) {
                    hiddenInput.value = '';
                    if (shouldFormatDisplay) {
                        displayInput.value = '';
                    }
                    return;
                }

                hiddenInput.value = String(parsedNumber);
                if (shouldFormatDisplay) {
                    displayInput.value = formatNumber(parsedNumber);
                }
            };

            displayInputs.forEach((input) => {
                syncHiddenInput(input, true);

                input.addEventListener('input', () => {
                    syncHiddenInput(input, false);
                });

                input.addEventListener('blur', () => {
                    syncHiddenInput(input, true);
                });
            });

            const forms = new Set(displayInputs.map((input) => input.form).filter(Boolean));
            forms.forEach((form) => {
                form.addEventListener('submit', () => {
                    displayInputs
                        .filter((input) => input.form === form)
                        .forEach((input) => {
                            syncHiddenInput(input, true);
                        });
                });
            });
        });
    </script>
@endpush

