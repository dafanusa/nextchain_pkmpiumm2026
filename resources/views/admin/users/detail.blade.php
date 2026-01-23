@extends('admin.layout')

@section('title', 'User Detail List')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold">Detail User</h2>
            <p class="text-sm text-[var(--muted)] mt-1">Ringkasan transaksi dan aktivitas user.</p>
        </div>
        <a href="{{ route('admin.users.index') }}"
           class="px-4 py-2 rounded-full border border-slate-200 text-sm font-semibold hover:border-[var(--brand)] transition">
            Users List
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-[760px] w-full text-sm">
                <thead class="bg-slate-50 text-[var(--muted)]">
                    <tr>
                        <th class="text-left px-4 py-3">Nama</th>
                        <th class="text-left px-4 py-3">Email</th>
                        <th class="text-left px-4 py-3">Total Poin</th>
                        <th class="text-left px-4 py-3">Order</th>
                        <th class="text-left px-4 py-3">Negosiasi</th>
                        <th class="text-left px-4 py-3">Testimoni</th>
                        <th class="text-right px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3 font-semibold text-[var(--ink)]">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-[var(--muted)]">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-[var(--muted)]">{{ $user->loyalty_points ?? 0 }}</td>
                            <td class="px-4 py-3 text-[var(--muted)]">{{ $user->orders_count }}</td>
                            <td class="px-4 py-3 text-[var(--muted)]">{{ $user->negotiation_offers_count }}</td>
                            <td class="px-4 py-3 text-[var(--muted)]">{{ $user->testimonials_count }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="inline-flex px-3 py-1.5 rounded-full border border-slate-200 text-xs font-semibold hover:border-[var(--brand)] transition">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-[var(--muted)]">Belum ada user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
@endsection

