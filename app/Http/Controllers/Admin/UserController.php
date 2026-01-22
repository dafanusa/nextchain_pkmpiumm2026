<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\NegotiationOffer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->withCount(['orders', 'negotiationOffers', 'testimonials'])
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.form', ['user' => new User]);
    }

    public function store(UserStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User dibuat.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.form', compact('user'));
    }

    public function detail(): View
    {
        $users = User::query()
            ->withCount(['orders', 'negotiationOffers', 'testimonials'])
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.users.detail', compact('users'));
    }

    public function show(User $user): View
    {
        $offerCounts = NegotiationOffer::query()
            ->selectRaw('status, count(*) as total')
            ->where('user_id', $user->id)
            ->groupBy('status')
            ->pluck('total', 'status');

        $offerSummary = [
            'total' => (int) $offerCounts->sum(),
            'accepted' => (int) ($offerCounts['accepted'] ?? 0),
            'rejected' => (int) ($offerCounts['rejected'] ?? 0),
            'pending' => (int) ($offerCounts['pending'] ?? 0),
        ];

        $totalSpend = (int) Order::query()
            ->where('user_id', $user->id)
            ->sum('total');

        $latestOrder = Order::query()
            ->where('user_id', $user->id)
            ->latest('created_at')
            ->first();

        $latestOffer = NegotiationOffer::query()
            ->where('user_id', $user->id)
            ->latest('created_at')
            ->first();

        $latestTestimonial = Testimonial::query()
            ->where('user_id', $user->id)
            ->latest('created_at')
            ->first();

        $latestPayment = Payment::query()
            ->whereHas('order', fn ($query) => $query->where('user_id', $user->id))
            ->latest('created_at')
            ->first();

        return view('admin.users.show', [
            'user' => $user,
            'ordersCount' => Order::query()->where('user_id', $user->id)->count(),
            'offerSummary' => $offerSummary,
            'testimonialsCount' => Testimonial::query()->where('user_id', $user->id)->count(),
            'totalSpend' => $totalSpend,
            'latestOrder' => $latestOrder,
            'latestOffer' => $latestOffer,
            'latestTestimonial' => $latestTestimonial,
            'totalProductsBought' => (int) OrderItem::query()
                ->whereHas('order', fn ($query) => $query->where('user_id', $user->id))
                ->sum('qty'),
            'latestPayment' => $latestPayment,
        ]);
    }

    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User dihapus.');
    }
}
