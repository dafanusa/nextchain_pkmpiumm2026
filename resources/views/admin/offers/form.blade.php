@extends('admin.layout')

@section('title', 'Edit Tawaran')

@section('content')
    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm max-w-2xl">
        @if ($errors->any())
            <div class="mb-4 rounded-2xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-4 text-sm text-[var(--muted)]">
            Produk: <span class="font-semibold text-[var(--ink)]">{{ $offer->product?->name ?? '-' }}</span>
        </div>

        <form method="post" action="{{ route('admin.offers.update', $offer) }}" class="space-y-4">
            @csrf
            @method('put')

            <div>
                <label class="text-sm font-semibold">Status</label>
                <select name="status" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                    <option value="pending" @selected(old('status', $offer->status) === 'pending')>Pending</option>
                    <option value="accepted" @selected(old('status', $offer->status) === 'accepted')>Accepted</option>
                    <option value="rejected" @selected(old('status', $offer->status) === 'rejected')>Rejected</option>
                </select>
            </div>
            <div>
                <label class="text-sm font-semibold">Catatan</label>
                <textarea name="note" rows="3"
                          class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">{{ old('note', $offer->note) }}</textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="px-5 py-2.5 rounded-full bg-[var(--brand)] text-white text-sm font-semibold hover:bg-[var(--brand-dark)] transition">
                    Simpan
                </button>
                <a href="{{ route('admin.offers.index') }}"
                   class="px-5 py-2.5 rounded-full border border-slate-200 text-sm font-semibold hover:border-[var(--brand)] transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
