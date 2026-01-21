@extends('admin.layout')

@section('title', 'Users')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold">Daftar Users</h2>
        <a href="{{ route('admin.users.create') }}"
           class="px-4 py-2 rounded-full bg-[var(--brand)] text-white text-sm font-semibold hover:bg-[var(--brand-dark)] transition">
            Tambah User
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded-2xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-[640px] w-full text-sm">
                <thead class="bg-slate-50 text-[var(--muted)]">
                    <tr>
                        <th class="text-left px-4 py-3">Nama</th>
                        <th class="text-left px-4 py-3">Email</th>
                        <th class="text-left px-4 py-3">Poin</th>
                        <th class="text-left px-4 py-3">Role</th>
                        <th class="text-right px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3 font-semibold text-[var(--ink)]">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-[var(--muted)]">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-[var(--muted)]">{{ $user->loyalty_points ?? 0 }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex px-2 py-1 rounded-full text-xs bg-slate-100 text-[var(--ink)]">{{ $user->role }}</span>
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="inline-flex px-3 py-1.5 rounded-full border border-slate-200 text-xs font-semibold hover:border-[var(--brand)] transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="post" class="inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit"
                                            onclick="return confirm('Hapus user ini?')"
                                            class="inline-flex px-3 py-1.5 rounded-full border border-red-200 text-xs font-semibold text-red-600 hover:border-red-300 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-[var(--muted)]">Belum ada user.</td>
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
