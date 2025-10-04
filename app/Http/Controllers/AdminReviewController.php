<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    // عرض كل التعليقات لكل المنتجات
    public function index()
    {
        // جلب كل Reviews مع المنتج واليوزر
        $reviews = Review::with(['user', 'product'])->get();

        return view('admin.reviews.index', compact('reviews'));
    }

    // حذف Review
    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully.');
    }
}
