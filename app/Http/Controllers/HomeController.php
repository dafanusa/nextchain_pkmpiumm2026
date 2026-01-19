<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::query()
            ->where('is_approved', true)
            ->latest('id')
            ->take(6)
            ->get();

        return view('home', compact('testimonials'));
    }
}
