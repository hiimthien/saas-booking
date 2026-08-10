<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateClientProfileRequest;
use App\Http\Requests\UpdateConsultantProfileRequest;
use App\Models\ConsultantProfile;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
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

        return response()->json([
            'success' => true,
            'message' => 'Consultant profile updated successfully',
            'data' => $profile
        ]);
    }
}
