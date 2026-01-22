@extends('admin.layout')

@section('title', 'Testimonials')

@section('content')
    <h2 class="text-lg font-semibold mb-6">Daftar Testimoni</h2>

    @if (session('success'))
        <div class="mb-4 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-[680px] w-full text-sm">
                <thead class="bg-slate-50 text-[var(--muted)]">
                    <tr>
                        <th class="text-left px-4 py-3">Nama</th>
                        <th class="text-left px-4 py-3">Rating</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-left px-4 py-3">Waktu</th>
                        <th class="text-right px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($testimonials as $testimonial)
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3 font-semibold text-[var(--ink)]">{{ $testimonial->name }}</td>
                            <td class="px-4 py-3 text-[var(--muted)]">{{ $testimonial->rating }}/5</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex px-2 py-1 rounded-full text-xs bg-slate-100 text-[var(--ink)]">
                                    {{ $testimonial->is_approved ? 'Approved' : 'Pending' }}
                                </span>
                                <div class="mt-2 text-xs text-[var(--muted)]">
                                    {{ $testimonial->message }}
                                </div>
                            </td>
                            <td class="px-4 py-3 text-[var(--muted)]">
                                {{ $testimonial->created_at?->timezone('Asia/Jakarta')->format('d M Y H:i') ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-right flex flex-wrap justify-end gap-2">
                                @if (! $testimonial->is_approved)
                                    <form action="{{ route('admin.testimonials.approve', $testimonial) }}" method="post" class="inline">
                                        @csrf
                                        @method('patch')
                                        <button type="submit"
                                                class="inline-flex px-3 py-1.5 rounded-full border border-emerald-200 text-xs font-semibold text-emerald-700 hover:border-emerald-300 transition">
                                            Terima
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="post" class="inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit"
                                            onclick="return confirm('Hapus testimoni ini?')"
                                            class="inline-flex px-3 py-1.5 rounded-full border border-red-200 text-xs font-semibold text-red-600 hover:border-red-300 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-[var(--muted)]">Belum ada testimoni.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $testimonials->links() }}
    </div>
@endsection



