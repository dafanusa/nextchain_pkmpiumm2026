<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryScheduleRequest;
use App\Models\DeliverySchedule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class DeliveryScheduleController extends Controller
{
    public function index(): View
    {
        $schedules = DeliverySchedule::query()
            ->orderBy('delivery_date')
            ->orderBy('delivery_time')
            ->paginate(12);

        return view('admin.delivery-schedules.index', compact('schedules'));
    }

    public function create(): View
    {
        return view('admin.delivery-schedules.form', [
            'schedule' => new DeliverySchedule,
        ]);
    }

    public function store(DeliveryScheduleRequest $request): RedirectResponse
    {
        $schedule = DeliverySchedule::create($request->validated());

        return redirect()
            ->route('admin.delivery-schedules.index')
            ->with('success', 'Jadwal pengiriman berhasil dibuat.');
    }

    public function edit(DeliverySchedule $deliverySchedule): View
    {
        return view('admin.delivery-schedules.form', [
            'schedule' => $deliverySchedule,
        ]);
    }

    public function update(DeliveryScheduleRequest $request, DeliverySchedule $deliverySchedule): RedirectResponse
    {
        $deliverySchedule->update($request->validated());

        return redirect()
            ->route('admin.delivery-schedules.edit', $deliverySchedule)
            ->with('success', 'Jadwal pengiriman berhasil diperbarui.');
    }

    public function destroy(DeliverySchedule $deliverySchedule): RedirectResponse
    {
        $deliverySchedule->delete();

        return redirect()
            ->route('admin.delivery-schedules.index')
            ->with('success', 'Jadwal pengiriman berhasil dihapus.');
    }
}
