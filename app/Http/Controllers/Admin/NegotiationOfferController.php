<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DateFilterRequest;
use App\Http\Requests\Admin\UpdateNegotiationOfferRequest;
use App\Models\NegotiationOffer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class NegotiationOfferController extends Controller
{
    public function index(DateFilterRequest $request): View
    {
        $date = $request->validated()['date'] ?? null;

        $offersQuery = NegotiationOffer::query()
            ->with(['product', 'user'])
            ->orderByDesc('id');

        if ($date) {
            $offersQuery->whereDate('created_at', $date);
        }

        $offers = $offersQuery->paginate(20)->withQueryString();

        return view('admin.offers.index', compact('offers'));
    }

    public function edit(NegotiationOffer $offer): View
    {
        return view('admin.offers.form', compact('offer'));
    }

    public function update(UpdateNegotiationOfferRequest $request, NegotiationOffer $offer): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($offer, $validated) {
            $status = $validated['status'];
            $offer->update([
                'status' => $status,
                'note' => $validated['note'] ?? null,
                'accepted_at' => $status === 'accepted' ? now() : null,
            ]);

            if ($status === 'accepted') {
                NegotiationOffer::query()
                    ->where('product_id', $offer->product_id)
                    ->where('id', '!=', $offer->id)
                    ->whereIn('status', ['pending', 'accepted'])
                    ->update([
                        'status' => 'rejected',
                        'accepted_at' => null,
                    ]);
            }
        });

        return redirect()->route('admin.offers.index')->with('success', 'Tawaran diperbarui.');
    }

    public function destroy(NegotiationOffer $offer): RedirectResponse
    {
        $offer->delete();

        return redirect()->route('admin.offers.index')->with('success', 'Tawaran dihapus.');
    }

    public function approve(NegotiationOffer $offer): RedirectResponse
    {
        $this->updateStatus($offer, 'accepted');

        return redirect()->route('admin.offers.index')->with('success', 'Tawaran disetujui.');
    }

    public function reject(NegotiationOffer $offer): RedirectResponse
    {
        $this->updateStatus($offer, 'rejected');

        return redirect()->route('admin.offers.index')->with('success', 'Tawaran ditolak.');
    }

    private function updateStatus(NegotiationOffer $offer, string $status): void
    {
        DB::transaction(function () use ($offer, $status) {
            $offer->update([
                'status' => $status,
                'accepted_at' => $status === 'accepted' ? now() : null,
            ]);

            if ($status === 'accepted') {
                NegotiationOffer::query()
                    ->where('product_id', $offer->product_id)
                    ->where('id', '!=', $offer->id)
                    ->whereIn('status', ['pending', 'accepted'])
                    ->update([
                        'status' => 'rejected',
                        'accepted_at' => null,
                    ]);
            }
        });
    }
}
