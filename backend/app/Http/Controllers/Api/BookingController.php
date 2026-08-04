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
}
