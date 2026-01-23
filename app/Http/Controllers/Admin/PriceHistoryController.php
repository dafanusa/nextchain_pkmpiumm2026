<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PriceHistoryController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::query()
            ->orderBy('name')
            ->get();

        $selectedProductId = (int) $request->query('product_id');
        $selectedProduct = $selectedProductId
            ? Product::query()->with(['priceHistories' => fn ($query) => $query->orderBy('price_date')])->find($selectedProductId)
            : null;

        $dailyLabels = [];
        $dailyMin = [];
        $dailyMax = [];
        $weeklyLabels = [];
        $weeklyMin = [];
        $weeklyMax = [];

        if ($selectedProduct) {
            $histories = $selectedProduct->priceHistories;
            $today = now('Asia/Jakarta')->startOfDay();

            if ($histories->isEmpty()) {
                $histories = collect([
                    new \App\Models\PriceHistory([
                        'price_date' => $today->copy(),
                        'price_min' => $selectedProduct->price_min,
                        'price_max' => $selectedProduct->price_max,
                        'source' => 'admin',
                    ]),
                ]);
            }

            $dailyStart = $today->copy()->subDays(13);
            $historyMap = $histories->keyBy(fn ($history) => $history->price_date->format('Y-m-d'));
            $current = $dailyStart->copy();
            while ($current->lte($today)) {
                $key = $current->format('Y-m-d');
                $history = $historyMap->get($key);
                $dailyLabels[] = $current->format('d M');
                $dailyMin[] = $history?->price_min;
                $dailyMax[] = $history?->price_max;
                $current->addDay();
            }

            $weeklyStart = $today->copy()->startOfWeek(Carbon::MONDAY)->subWeeks(7);
            for ($week = 0; $week < 8; $week++) {
                $start = $weeklyStart->copy()->addWeeks($week);
                $end = $start->copy()->endOfWeek(Carbon::SUNDAY);
                $weekData = $histories->filter(fn ($history) => $history->price_date->between($start, $end));
                $weeklyLabels[] = $start->format('d M');
                $weeklyMin[] = $weekData->isEmpty() ? null : (int) round($weekData->avg('price_min'));
                $weeklyMax[] = $weekData->isEmpty() ? null : (int) round($weekData->avg('price_max'));
            }
        }

        return view('admin.price-histories.index', [
            'products' => $products,
            'selectedProduct' => $selectedProduct,
            'dailyLabels' => $dailyLabels,
            'dailyMin' => $dailyMin,
            'dailyMax' => $dailyMax,
            'weeklyLabels' => $weeklyLabels,
            'weeklyMin' => $weeklyMin,
            'weeklyMax' => $weeklyMax,
        ]);
    }
}
