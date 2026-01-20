@extends('admin.layout')

@section('title', $user->exists ? 'Edit User' : 'Tambah User')

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

        <form method="post"
              action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}"
              class="space-y-4">
            @csrf
            @if ($user->exists)
                @method('put')
            @endif

            <div>
                <label class="text-sm font-semibold">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
            </div>
            <div>
                <label class="text-sm font-semibold">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
            </div>
            <div>
                <label class="text-sm font-semibold">Role</label>
                <select name="role" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                    <option value="user" @selected(old('role', $user->role) === 'user')>User</option>
                    <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                </select>
            </div>
            <div>
                <label class="text-sm font-semibold">Loyalty Points</label>
                <input type="number" name="loyalty_points" min="0" value="{{ old('loyalty_points', $user->loyalty_points ?? 0) }}"
                       class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
            </div>
            @if (!$user->exists)
                <div>
                    <label class="text-sm font-semibold">Password</label>
                    <input type="password" name="password" required
                           class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                </div>
            @endif

            <div class="flex gap-3">
                <button type="submit"
                        class="px-5 py-2.5 rounded-full bg-[var(--brand)] text-white text-sm font-semibold hover:bg-[var(--brand-dark)] transition">
                    Simpan
                </button>
                <a href="{{ route('admin.users.index') }}"
                   class="px-5 py-2.5 rounded-full border border-slate-200 text-sm font-semibold hover:border-[var(--brand)] transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
