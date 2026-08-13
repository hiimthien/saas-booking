<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\ConsultationResource;
use App\Models\ConsultantProfile;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    protected $bookingService;

    // Inject the BookingService via the constructor
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Display a listing of the user's bookings.
     */
    public function index()
    {
        $user = auth()->user();
        
        $query = \App\Models\Consultation::with('consultantProfile.user')
            ->orderBy('start_time', 'desc');
            
        if ($user->role === 'consultant') {
            // Get bookings for this consultant
            $profile = \App\Models\ConsultantProfile::where('user_id', $user->id)->first();
            if ($profile) {
                $query->where('consultant_profile_id', $profile->id);
            } else {
                $query->where('customer_id', $user->id); // fallback
            }
        } else {
            // Get bookings for this customer
            $query->where('customer_id', $user->id);
        }
        
        $consultations = $query->get();
        
        return response()->json([
            'success' => true,
            'data' => ConsultationResource::collection($consultations)
        ]);
    }

    /**
     * Store a newly created consultation in storage.
     *
     * @param StoreBookingRequest $request
     * @return JsonResponse
     */
    public function store(StoreBookingRequest $request): JsonResponse
    {
        $validated = $request->validated();
        
        $consultant = ConsultantProfile::findOrFail($validated['consultant_profile_id']);
        
        // Get the authenticated user's ID
        $customerId = auth()->id(); 

        try {
            $consultation = $this->bookingService->createBooking(
                $customerId,
                $consultant,
                $validated['start_time'],
                $validated['duration_minutes'],
                $validated['notes'] ?? null
            );

            return response()->json([
                'success' => true,
                'message' => 'Booking created successfully.',
                'data' => new ConsultationResource($consultation)
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create booking: ' . $e->getMessage(),
            ], 400);
        }
    }

    public function show($id): JsonResponse
    {
        $consultation = \App\Models\Consultation::with('consultantProfile.user')->findOrFail($id);
        
        // Ensure user can only see their own booking (simplified auth check for demo)
        if ($consultation->customer_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'success' => true,
            'data' => new ConsultationResource($consultation)
        ]);
    }

    /**
     * Cancel a booking.
     */
    public function cancel($id): JsonResponse
    {
        try {
            $this->bookingService->cancelBooking((int)$id, auth()->id());
            
            return response()->json([
                'success' => true,
                'message' => 'Booking cancelled successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel booking: ' . $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Dispute/Report a booking.
     */
    public function report($id, Request $request): JsonResponse
    {
        $request->validate([
            'reason' => 'required|string|max:1000'
        ]);

        $consultation = \App\Models\Consultation::findOrFail($id);

        if ($consultation->customer_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if (!in_array($consultation->status, ['confirmed', 'completed'])) {
            return response()->json(['success' => false, 'message' => 'You can only report confirmed or completed bookings.'], 400);
        }

        // Change status to disputed to prevent payout
        $consultation->status = 'disputed';
        $consultation->notes = "Dispute Reason: " . $request->reason . "\n" . $consultation->notes;
        $consultation->save();

        return response()->json([
            'success' => true,
            'message' => 'Booking has been reported and funds are held for admin review.',
        ]);
    }
}
