<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderByDesc('id')->paginate(20);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.form', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'message' => ['required', 'string'],
            'is_approved' => ['required', 'boolean'],
        ]);

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni diperbarui.');
    }

    public function approve(Testimonial $testimonial): RedirectResponse
    {
        if (! $testimonial->is_approved) {
            $testimonial->update(['is_approved' => true]);
        }

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni disetujui.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni dihapus.');
    }
}
