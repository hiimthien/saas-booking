<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateAvailabilityRequest;
use App\Models\WorkingHour;

class AvailabilityController extends Controller
{
    public function index(Request $request)
    {
        $profile = $request->user()->consultantProfile;
        
        if (!$profile) {
            return response()->json(['success' => false, 'message' => 'Consultant profile not found.'], 404);
        }

        $workingHours = $profile->workingHours()->orderBy('day_of_week')->get();
        
        // If empty, initialize 7 days
        if ($workingHours->isEmpty()) {
            $defaultHours = [];
            for ($i = 0; $i < 7; $i++) {
                $defaultHours[] = [
                    'consultant_profile_id' => $profile->id,
                    'day_of_week' => $i,
                    'start_time' => '09:00:00',
                    'end_time' => '17:00:00',
                    'is_closed' => ($i === 0 || $i === 6) ? true : false, // Close on weekends by default
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            WorkingHour::insert($defaultHours);
            $workingHours = $profile->workingHours()->orderBy('day_of_week')->get();
        }

        return response()->json(['success' => true, 'data' => $workingHours]);
    }

    public function update(UpdateAvailabilityRequest $request)
    {
        $validated = $request->validated();

        $profile = $request->user()->consultantProfile;

        foreach ($request->working_hours as $hour) {
            WorkingHour::updateOrCreate(
                ['consultant_profile_id' => $profile->id, 'day_of_week' => $hour['day_of_week']],
                [
                    'start_time' => $hour['start_time'],
                    'end_time' => $hour['end_time'],
                    'is_closed' => $hour['is_closed'],
                ]
            );
        }

        return response()->json(['success' => true, 'message' => 'Availabilities updated successfully.']);
    }
}
