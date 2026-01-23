@extends('admin.layout')

@section('title', 'Delivery Schedules')

@section('content')
    <div class="flex items-center justify-between gap-4 mb-6">
        <h2 class="text-lg font-semibold">Daftar Jadwal Pengiriman</h2>
        <a href="{{ route('admin.delivery-schedules.create') }}"
           class="px-4 py-2 rounded-full bg-[var(--brand)] text-white text-sm font-semibold hover:bg-[var(--brand-dark)] transition whitespace-nowrap">
            Tambah Jadwal
        </a>
    </div>

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
                        <th class="text-left px-4 py-3">Tujuan</th>
                        <th class="text-left px-4 py-3">Tipe</th>
                        <th class="text-left px-4 py-3">Tanggal</th>
                        <th class="text-left px-4 py-3">Jam</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-right px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($schedules as $schedule)
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3 text-[var(--ink)] font-semibold">{{ $schedule->destination }}</td>
                            <td class="px-4 py-3 text-[var(--muted)]">
                                {{ $schedule->schedule_type === 'pickup' ? 'Pickup' : 'Terjadwal' }}
                            </td>
                            <td class="px-4 py-3 text-[var(--muted)]">{{ $schedule->delivery_date->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-[var(--muted)]">{{ $schedule->delivery_time }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $schedule->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $schedule->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('admin.delivery-schedules.edit', $schedule) }}"
                                   class="inline-flex px-3 py-1.5 rounded-full border border-slate-200 text-xs font-semibold hover:border-[var(--brand)] transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.delivery-schedules.destroy', $schedule) }}" method="post" class="inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit"
                                            onclick="return confirm('Hapus jadwal ini?')"
                                            class="inline-flex px-3 py-1.5 rounded-full border border-red-200 text-xs font-semibold text-red-600 hover:border-red-300 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-[var(--muted)]">Belum ada jadwal.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $schedules->links() }}
    </div>
@endsection




