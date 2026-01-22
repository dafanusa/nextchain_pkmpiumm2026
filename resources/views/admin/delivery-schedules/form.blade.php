@extends('admin.layout')

@section('title', $schedule->exists ? 'Edit Jadwal Pengiriman' : 'Tambah Jadwal Pengiriman')

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

        <form method="post"
              action="{{ $schedule->exists ? route('admin.delivery-schedules.update', $schedule) : route('admin.delivery-schedules.store') }}"
              class="space-y-4">
            @csrf
            @if ($schedule->exists)
                @method('put')
            @endif

            <div class="grid sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold">Tujuan Pengiriman</label>
                    <input type="text" name="destination" value="{{ old('destination', $schedule->destination) }}" required
                           placeholder="Contoh: Pasar Induk, Surabaya"
                           class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="text-sm font-semibold">Tanggal</label>
                    <input type="date" name="delivery_date" value="{{ old('delivery_date', $schedule->delivery_date?->format('Y-m-d')) }}" required
                           class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="text-sm font-semibold">Jam</label>
                    <input type="text" name="delivery_time" value="{{ old('delivery_time', $schedule->delivery_time) }}" required
                           placeholder="Contoh: 08.00 - 11.00"
                           class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="text-sm font-semibold">Status</label>
                    <select name="is_active" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                        <option value="1" @selected(old('is_active', $schedule->is_active ?? true))>Aktif</option>
                        <option value="0" @selected(old('is_active', $schedule->is_active ?? true) == false)>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="px-5 py-2.5 rounded-full bg-[var(--brand)] text-white text-sm font-semibold hover:bg-[var(--brand-dark)] transition">
                    Simpan
                </button>
                <a href="{{ route('admin.delivery-schedules.index') }}"
                   class="px-5 py-2.5 rounded-full border border-slate-200 text-sm font-semibold hover:border-[var(--brand)] transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection



