<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DateFilterRequest;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(DateFilterRequest $request): View
    {
        $date = $request->validated()['date'] ?? null;

        $ordersQuery = Order::query()->with('user')->orderByDesc('id');

        if ($date) {
            $ordersQuery->whereDate('created_at', $date);
        }

        $orders = $ordersQuery->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['items.product', 'payments']);

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,processing,completed,canceled'],
            'payment_status' => ['required', 'in:unpaid,paid,failed,refunded'],
            'shipping_status' => ['required', 'in:processing,shipped,delivered'],
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order diperbarui.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order dihapus.');
    }
}
