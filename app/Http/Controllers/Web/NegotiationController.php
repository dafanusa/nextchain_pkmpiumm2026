<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\NegotiationMessageRequest;
use App\Http\Requests\NegotiationOfferRequest;
use App\Models\NegotiationMessage;
use App\Models\NegotiationOffer;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class NegotiationController extends Controller
{
    public function store(NegotiationOfferRequest $request, int $id): JsonResponse
    {
        $validated = $request->validated();
        $product = Product::find($id);
        if (! $product) {
            abort(404);
        }

        $price = (int) $validated['price'];
        if ($price < $product->price_min || $price > $product->price_max) {
            return response()->json([
                'message' => 'Harga tawaran harus di dalam rentang produk.',
            ], 422);
        }

        $offer = NegotiationOffer::create([
            'product_id' => $id,
            'user_id' => $request->user()->id,
            'price' => $price,
            'qty' => $validated['qty'],
            'channel' => $validated['channel'] ?? 'chat',
            'status' => 'pending',
            'note' => $validated['note'] ?? null,
        ]);

        return response()->json([
            'message' => 'Tawaran terkirim.',
            'offer_id' => $offer->id,
            'status' => $offer->status,
        ]);
    }

    public function storeMessage(NegotiationMessageRequest $request, int $id): JsonResponse
    {
        $validated = $request->validated();

        $offer = NegotiationOffer::query()
            ->where('id', $validated['offer_id'])
            ->where('product_id', $id)
            ->firstOrFail();

        if ($offer->user_id !== $request->user()->id) {
            abort(403);
        }

        $message = NegotiationMessage::create([
            'negotiation_offer_id' => $offer->id,
            'user_id' => $request->user()->id,
            'sender_role' => 'buyer',
            'message' => $validated['message'],
        ]);

        return response()->json([
            'message' => 'Pesan terkirim.',
            'data' => [
                'id' => $message->id,
                'message' => $message->message,
                'created_at' => $message->created_at?->diffForHumans(),
            ],
        ]);
    }
}
