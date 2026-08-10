<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConsultantProfile;
use App\Models\User;

class AdminConsultantController extends Controller
{
    public function pending(Request $request)
    {
        // For MVP, we just list all consultants. 
        // In a real scenario, we would filter by a 'status' or 'is_verified' flag.
        // Let's assume we return all profiles with their user data.
        $profiles = ConsultantProfile::with('user')->orderBy('created_at', 'desc')->get();
        return response()->json(['success' => true, 'data' => $profiles]);
    }

    public function approve(Request $request, $id)
    {
        $profile = ConsultantProfile::findOrFail($id);
        // $profile->is_verified = true;
        // $profile->save();
        return response()->json(['success' => true, 'message' => "Consultant profile {$profile->id} approved."]);
    }

    public function reject(Request $request, $id)
    {
        $profile = ConsultantProfile::findOrFail($id);
        // $profile->is_verified = false;
        // $profile->save();
        return response()->json(['success' => true, 'message' => "Consultant profile {$profile->id} rejected."]);
    }
}
