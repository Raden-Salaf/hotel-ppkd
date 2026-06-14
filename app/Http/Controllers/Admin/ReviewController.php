<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('booking')
            ->latest()->paginate(15);

        $avgRating = Review::where('is_published', true)->avg('rating');

        return view('admin.reviews.index', compact('reviews', 'avgRating'));
    }

    public function reply(Request $request, Review $review)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:1000',
        ]);

        $review->update([
            'admin_reply' => $request->admin_reply,
            'replied_by'  => auth()->id(),
            'replied_at'  => now(),
        ]);

        return back()->with('success', 'Balasan berhasil disimpan.');
    }

    public function togglePublish(Review $review)
    {
        $review->update(['is_published' => !$review->is_published]);
        return back()->with('success', 'Status ulasan berhasil diubah.');
    }
}