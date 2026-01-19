<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NegotiationOffer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $months = collect(range(0, 5))
            ->map(fn (int $offset) => Carbon::now()->subMonths(5 - $offset)->startOfMonth());
        $orderBuckets = Order::query()
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->pluck('total', 'month');
        $orderChart = [
            'labels' => $months->map(fn (Carbon $date) => $date->format('M'))->all(),
            'values' => $months->map(fn (Carbon $date) => (int) ($orderBuckets[$date->format('Y-m')] ?? 0))->all(),
        ];
        $offerStatus = [
            'pending' => NegotiationOffer::where('status', 'pending')->count(),
            'accepted' => NegotiationOffer::where('status', 'accepted')->count(),
            'rejected' => NegotiationOffer::where('status', 'rejected')->count(),
        ];

        $stats = [
            'users' => User::count(),
            'products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'low_stock' => Product::where('stock', '<=', 10)->count(),
            'total_stock' => Product::sum('stock'),
            'top_products' => Product::orderByDesc('stock')->take(3)->get(['name', 'stock', 'unit']),
            'orders' => Order::count(),
            'testimonials' => Testimonial::where('is_approved', false)->count(),
            'latest_user' => User::latest('id')->value('email'),
            'latest_order' => Order::latest('id')->value('order_number'),
            'latest_testimonial' => Testimonial::latest('id')->value('name'),
            'order_chart' => $orderChart,
            'offer_status' => $offerStatus,
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
