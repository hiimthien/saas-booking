<?php

namespace App\Http\Controllers\Api\Consultant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateClientProfileRequest;
use App\Http\Requests\UpdateConsultantProfileRequest;
use App\Http\Requests\BecomeConsultantRequest;
use App\Models\ConsultantProfile;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;

class ConsultantProfileController extends Controller
{
    public function updateConsultantProfile(UpdateConsultantProfileRequest $request)
    {
        $user = $request->user();
        
        $validated = $request->validated();

        $profile = ConsultantProfile::firstOrCreate(
            ['user_id' => $user->id],
            ['slug' => \Illuminate\Support\Str::slug($user->name) . '-' . uniqid(), 'title' => $validated['title'], 'hourly_rate' => $validated['hourly_rate']]
        );

        $profile->title = $validated['title'];
        $profile->hourly_rate = $validated['hourly_rate'];
        $profile->bio = $validated['bio'] ?? null;
        $profile->save();

        if (isset($validated['tags'])) {
            $profile->tags()->sync($validated['tags']);
        }

        $profile->load('tags', 'user');

        // Clear the cache for this consultant profile
        \Illuminate\Support\Facades\Cache::forget('consultant.profile.' . $profile->slug);

        return response()->json([
            'success' => true,
            'message' => 'Consultant profile updated successfully',
            'data' => $profile
        ]);
    }
}
