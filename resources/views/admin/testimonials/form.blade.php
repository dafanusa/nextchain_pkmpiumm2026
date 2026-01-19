@extends('admin.layout')

@section('title', 'Edit Testimoni')

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

        <form method="post" action="{{ route('admin.testimonials.update', $testimonial) }}" class="space-y-4">
            @csrf
            @method('put')

            <div>
                <label class="text-sm font-semibold">Nama</label>
                <input type="text" name="name" value="{{ old('name', $testimonial->name) }}" required
                       class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
            </div>
            <div>
                <label class="text-sm font-semibold">Peran/Usaha</label>
                <input type="text" name="role" value="{{ old('role', $testimonial->role) }}"
                       class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
            </div>
            <div>
                <label class="text-sm font-semibold">Rating</label>
                <select name="rating" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                    @for ($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" @selected(old('rating', $testimonial->rating) == $i)>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="text-sm font-semibold">Pesan</label>
                <textarea name="message" rows="4" required
                          class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">{{ old('message', $testimonial->message) }}</textarea>
            </div>
            <div>
                <label class="text-sm font-semibold">Status</label>
                <select name="is_approved" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                    <option value="1" @selected(old('is_approved', $testimonial->is_approved) == true)>Approved</option>
                    <option value="0" @selected(old('is_approved', $testimonial->is_approved) == false)>Pending</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="px-5 py-2.5 rounded-full bg-[var(--brand)] text-white text-sm font-semibold hover:bg-[var(--brand-dark)] transition">
                    Simpan
                </button>
                <a href="{{ route('admin.testimonials.index') }}"
                   class="px-5 py-2.5 rounded-full border border-slate-200 text-sm font-semibold hover:border-[var(--brand)] transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
