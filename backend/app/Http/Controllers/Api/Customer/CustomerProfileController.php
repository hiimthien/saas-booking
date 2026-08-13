<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateClientProfileRequest;
use App\Http\Requests\UpdateConsultantProfileRequest;
use App\Http\Requests\BecomeConsultantRequest;
use App\Models\ConsultantProfile;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;

class CustomerProfileController extends Controller
{
    public function updateClientProfile(UpdateClientProfileRequest $request)
    {
        $user = $request->user();

        $validated = $request->validated();

        $user->name = $validated['name'];
        if (array_key_exists('phone', $validated)) {
            $user->phone = $validated['phone'];
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar_url && str_starts_with($user->avatar_url, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $user->avatar_url);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar_url = '/storage/' . $path;
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => new UserResource($user)
        ]);
    }

    public function becomeConsultant(BecomeConsultantRequest $request)
    {
        $user = $request->user();
        $validated = $request->validated();

        // Check if profile already exists
        $profile = ConsultantProfile::where('user_id', $user->id)->first();
        
        if ($profile) {
            return response()->json([
                'success' => false,
                'message' => 'You have already submitted a request or are already a consultant.'
            ], 400);
        }

        $profile = ConsultantProfile::create([
            'user_id' => $user->id,
            'slug' => \Illuminate\Support\Str::slug($user->name) . '-' . uniqid(),
            'title' => $validated['title'],
            'hourly_rate' => $validated['hourly_rate'],
            'bio' => $validated['bio'] ?? null,
            'is_active' => false // Explicitly set to false (pending admin approval)
        ]);

        if (isset($validated['tags'])) {
            $profile->tags()->sync($validated['tags']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Request submitted successfully. Please wait for admin approval.',
            'data' => $profile
        ], 201);
    }
}
