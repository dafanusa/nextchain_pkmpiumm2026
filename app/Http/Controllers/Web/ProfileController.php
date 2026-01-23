<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Cart;
use App\Models\NegotiationOffer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        $user = $request->user();
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

        $profilePhotoUrl = $user->profile_photo_path
            ? Storage::disk('public')->url($user->profile_photo_path)
            : null;

        $cartCount = Cart::query()
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->with('items')
            ->get()
            ->flatMap(fn (Cart $cart) => $cart->items)
            ->sum('qty');

        $orders = Order::query()
            ->where('user_id', $user->id)
            ->with(['items.product'])
            ->latest()
            ->get();

        return view('profile.index', [
            'user' => $user,
            'ordersCount' => Order::query()->where('user_id', $user->id)->count(),
            'offerSummary' => $offerSummary,
            'testimonialsCount' => Testimonial::query()->where('user_id', $user->id)->count(),
            'totalProductsBought' => (int) OrderItem::query()
                ->whereHas('order', fn ($query) => $query->where('user_id', $user->id))
                ->sum('qty'),
            'profilePhotoUrl' => $profilePhotoUrl,
            'cartCount' => $cartCount,
            'orders' => $orders,
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->safe()->only(['name', 'whatsapp']);

        if ($request->filled('password')) {
            $data['password'] = $request->input('password');
        }

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $data['profile_photo_path'] = $request->file('profile_photo')
                ->storePublicly('profil', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function destroyPhoto(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
            $user->update(['profile_photo_path' => null]);
        }

        return back()->with('success', 'Foto profil dihapus.');
    }
}
