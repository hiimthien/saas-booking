<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConsultantProfileResource;
use App\Services\ConsultantService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ConsultantController extends Controller
{
    protected ConsultantService $consultantService;

    public function __construct(ConsultantService $consultantService)
    {
        $this->consultantService = $consultantService;
    }

    /**
     * Display a listing of active consultants.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = $request->query('per_page', 15);
        $filters = $request->only(['search', 'tags', 'min_price', 'max_price', 'rating']);
        
        $consultants = $this->consultantService->getActiveConsultants((int) $perPage, $filters);

        return ConsultantProfileResource::collection($consultants);
    }

    /**
     * Display the specified consultant by slug.
     */
    public function show(string $slug): ConsultantProfileResource
    {
        $consultant = $this->consultantService->getConsultantBySlug($slug);

        return new ConsultantProfileResource($consultant);
    }

    /**
     * Get available 30-min slots for a specific date.
     */
    public function availableSlots(Request $request, $id)
    {
        $date = $request->query('date');
        if (!$date) {
            return response()->json(['success' => false, 'message' => 'Date parameter is required (YYYY-MM-DD)'], 400);
        }

        $carbonDate = \Carbon\Carbon::parse($date);
        $dayOfWeek = strtolower($carbonDate->format('l')); // e.g., 'monday'

        // 1. Get working hours for this consultant on this day
        $workingHour = \App\Models\WorkingHour::where('consultant_profile_id', $id)
            ->where('day_of_week', $dayOfWeek)
            ->first();

        if (!$workingHour || !$workingHour->is_working) {
            return response()->json(['success' => true, 'data' => []]); // No slots
        }

        $workStart = \Carbon\Carbon::parse($date . ' ' . $workingHour->start_time);
        $workEnd = \Carbon\Carbon::parse($date . ' ' . $workingHour->end_time);

        // 2. Get existing bookings for this day
        $bookings = \App\Models\Consultation::where('consultant_profile_id', $id)
            ->whereDate('start_time', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();

        $slots = [];
        $currentSlot = $workStart->copy();

        // 3. Generate 30-min slots and filter out overlapping ones
        while ($currentSlot->copy()->addMinutes(30)->lte($workEnd)) {
            $slotStart = $currentSlot->copy();
            $slotEnd = $currentSlot->copy()->addMinutes(30);
            
            $isOverlap = false;
            foreach ($bookings as $booking) {
                $bookingStart = \Carbon\Carbon::parse($booking->start_time);
                $bookingEnd = \Carbon\Carbon::parse($booking->end_time);

                // Check overlap
                if ($slotStart->lt($bookingEnd) && $slotEnd->gt($bookingStart)) {
                    $isOverlap = true;
                    break;
                }
            }

            // Also check if slot is in the past
            if (!$isOverlap && $slotStart->isFuture()) {
                $slots[] = $slotStart->format('H:i');
            }

            $currentSlot->addMinutes(30);
        }

        return response()->json([
            'success' => true,
            'data' => $slots
        ]);
    }
}
