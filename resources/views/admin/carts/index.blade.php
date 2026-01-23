@extends('admin.layout')

@section('title', 'Carts')

@section('content')
    <h2 class="text-lg font-semibold mb-6">Daftar Cart</h2>

    @if (session('success'))
        <div class="mb-4 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-130 w-full text-sm">
                <thead class="bg-slate-50 text-[var(--muted)]">
                    <tr>
                        <th class="text-left px-4 py-3">User</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-right px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($carts as $cart)
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3 text-[var(--ink)]">{{ $cart->user?->name ?? 'Guest' }}</td>
                            <td class="px-4 py-3 text-[var(--muted)]">{{ $cart->status }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('admin.carts.show', $cart) }}"
                                   class="inline-flex px-3 py-1.5 rounded-full border border-slate-200 text-xs font-semibold hover:border-[var(--brand)] transition">
                                    Detail
                                </a>
                                <form action="{{ route('admin.carts.destroy', $cart) }}" method="post" class="inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit"
                                            onclick="return confirm('Hapus cart ini?')"
                                            class="inline-flex px-3 py-1.5 rounded-full border border-red-200 text-xs font-semibold text-red-600 hover:border-red-300 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-[var(--muted)]">Belum ada cart.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $carts->links() }}
    </div>
@endsection




