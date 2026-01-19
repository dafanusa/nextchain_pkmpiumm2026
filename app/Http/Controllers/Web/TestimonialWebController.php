<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialWebController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'role' => ['nullable', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        Testimonial::create([
            'user_id' => $request->user()->id,
            'name' => $request->user()->name,
            'role' => $validated['role'] ?? null,
            'rating' => $validated['rating'],
            'message' => $validated['message'],
            'is_approved' => false,
        ]);

        return back()->with('success', 'Testimoni terkirim dan menunggu persetujuan admin.');
    }
}
