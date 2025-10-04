<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateReviewRequest;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(CreateReviewRequest $request)
    {
        $validated = $request->validated();

        $review = Review::create([
            'user_id' => Auth::id(),
            'product_id' => $validated['product_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()
            ->back()
            ->with('success', '✅ Review submitted successfully!');
    }
}