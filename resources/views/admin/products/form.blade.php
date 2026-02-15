@extends('admin.layout')

@section('title', $product->exists ? 'Edit Produk' : 'Tambah Produk')

@section('content')
    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm max-w-3xl">
        @if ($errors->any())
            <div class="mb-4 rounded-2xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" enctype="multipart/form-data"
              action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
              class="space-y-4">
            @csrf
            @if ($product->exists)
                @method('put')
            @endif

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-semibold">Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                           class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="text-sm font-semibold">Supplier</label>
                    <input type="text" name="supplier" value="{{ old('supplier', $product->supplier) }}" required
                           class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="text-sm font-semibold">Grade</label>
                    <input type="text" name="grade" value="{{ old('grade', $product->grade) }}"
                           class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="text-sm font-semibold">Unit</label>
                    <input type="text" name="unit" value="{{ old('unit', $product->unit) }}" required
                           class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="text-sm font-semibold">Harga Min</label>
                    <input type="number" name="price_min" value="{{ old('price_min', $product->price_min) }}" required
                           class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="text-sm font-semibold">Harga Max</label>
                    <input type="number" name="price_max" value="{{ old('price_max', $product->price_max) }}" required
                           class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="text-sm font-semibold">MOQ</label>
                    <input type="number" name="moq" value="{{ old('moq', $product->moq ?? 1) }}" required
                           class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="text-sm font-semibold">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required
                           class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold">Gambar Utama</label>
                    <input type="file" name="image_file" accept=".jpg,.jpeg,.png,.webp"
                           class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                    <p class="text-xs text-[var(--muted)] mt-2">
                        Upload gambar akan disimpan ke storage. Kosongkan jika tidak ingin mengganti.
                    </p>
                </div>
                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold">Galeri Produk (Multi Gambar)</label>
                    <input type="file" name="gallery_images[]" accept=".jpg,.jpeg,.png,.webp" multiple
                           class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                    <p class="text-xs text-[var(--muted)] mt-2">
                        Kamu bisa pilih beberapa gambar sekaligus untuk ditampilkan di detail produk.
                    </p>
                    @if ($product->exists && $product->images->isNotEmpty())
                        <div class="mt-3 grid grid-cols-3 sm:grid-cols-6 gap-2">
                            @foreach ($product->images as $image)
                                <img src="{{ $image->image_url }}"
                                     alt="Galeri {{ $product->name }}"
                                     class="h-16 w-full rounded-xl object-cover border border-slate-200">
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold">Path Gambar (opsional)</label>
                    <input type="text" name="image" value="{{ old('image', $product->image) }}"
                           class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold">Deskripsi</label>
                    <textarea name="description" rows="4"
                              class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">{{ old('description', $product->description) }}</textarea>
                </div>
                <div>
                    <label class="text-sm font-semibold">Aktif</label>
                    <select name="is_active" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                        <option value="1" @selected(old('is_active', $product->is_active ?? true) == true)>Aktif</option>
                        <option value="0" @selected(old('is_active', $product->is_active ?? true) == false)>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="px-5 py-2.5 rounded-full bg-[var(--brand)] text-white text-sm font-semibold hover:bg-[var(--brand-dark)] transition">
                    Simpan
                </button>
                <a href="{{ route('admin.products.index') }}"
                   class="px-5 py-2.5 rounded-full border border-slate-200 text-sm font-semibold hover:border-[var(--brand)] transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection




