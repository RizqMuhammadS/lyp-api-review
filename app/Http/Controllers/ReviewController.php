<?php
// app/Http/Controllers/ReviewController.php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        // Retrieve all reviews with the average rating
        $reviews = Review::all();
        $averageRating = round($reviews->avg('rating'), 1);

        return response()->json([
            'average_rating' => $averageRating,
            'reviews' => $reviews,
        ]);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'username' => 'required|string|max:255',
            'comment' => 'nullable|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review = Review::create($request->all());

        return response()->json([
            'message' => 'Review added successfully',
            'review' => $review,
        ], 201);
    }

    public function show($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        return response()->json($review);
    }

    public function update(Request $request, $id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $request->validate([
            'username' => 'required|string|max:255',
            'comment' => 'nullable|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review->update($request->all());

        return response()->json([
            'message' => 'Review updated successfully',
            'review' => $review,
        ]);
    }

    public function destroy($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted successfully']);
    }
}
