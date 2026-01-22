<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $testimonials = Testimonial::query()
            ->where('is_approved', true)
            ->latest('id')
            ->take(6)
            ->get();

        $featuredProducts = Product::query()
            ->where('is_active', true)
            ->latest('id')
            ->take(3)
            ->get();
        $heroProduct = $featuredProducts->first();
        $heroPriceMin = $heroProduct?->price_min ?? 26000;
        $heroPriceMax = $heroProduct?->price_max ?? 28000;
        $heroUnit = $heroProduct?->unit ?? 'kg';
        $heroGrade = $heroProduct?->grade ?? 'A';

        return view('pages.home', compact(
            'testimonials',
            'featuredProducts',
            'heroProduct',
            'heroPriceMin',
            'heroPriceMax',
            'heroUnit',
            'heroGrade'
        ));
    }
}
