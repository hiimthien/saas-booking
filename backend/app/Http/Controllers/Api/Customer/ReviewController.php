<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Consultation;
use App\Models\Review;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    /**
     * Store a new review for a completed consultation.
     */
    public function store(StoreReviewRequest $request, $bookingId)
    {
        $validated = $request->validated();
        $consultation = Consultation::findOrFail($bookingId);

        // Security check
        if ($consultation->customer_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Must be completed to review
        if ($consultation->status !== 'completed') {
            return response()->json(['success' => false, 'message' => 'You can only review completed consultations.'], 400);
        }
        
        $review = Review::create([
            'consultant_profile_id' => $consultation->consultant_profile_id,
            'customer_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully.',
            'data' => $review
        ], 201);
    }

    /**
     * Update the specified review.
     */
    public function update(UpdateReviewRequest $request, $id)
    {
        $review = Review::findOrFail($id);
        
        Gate::authorize('update', $review);

        $review->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Review updated successfully.',
            'data' => $review
        ]);
    }

    /**
     * Remove the specified review.
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        
        Gate::authorize('delete', $review);

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully.'
        ]);
    }
}
