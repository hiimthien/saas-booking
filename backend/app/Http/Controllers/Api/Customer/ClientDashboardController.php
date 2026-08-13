<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ToggleFavoriteRequest;
use App\Http\Requests\UpdateNotificationSettingsRequest;
use App\Models\Payment;
use App\Models\Review;
use App\Models\ConsultantProfile;

class ClientDashboardController extends Controller
{
    public function getPayments(Request $request)
    {
        $payments = Payment::whereHas('consultation', function ($q) use ($request) {
            $q->where('customer_id', $request->user()->id);
        })->with('consultation.consultantProfile.user')->orderBy('created_at', 'desc')->get();
        
        return response()->json(['success' => true, 'data' => $payments]);
    }

    public function getReviews(Request $request)
    {
        $reviews = Review::where('customer_id', $request->user()->id)
            ->with('consultantProfile.user')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json(['success' => true, 'data' => $reviews]);
    }

    public function getFavorites(Request $request)
    {
        $favorites = $request->user()->favorites()->with('user')->get();
        return response()->json(['success' => true, 'data' => $favorites]);
    }

    public function toggleFavorite(ToggleFavoriteRequest $request)
    {
        $validated = $request->validated();
        $request->user()->favorites()->toggle($request->consultant_profile_id);
        return response()->json(['success' => true, 'message' => 'Favorites updated']);
    }

    public function updateNotificationSettings(UpdateNotificationSettingsRequest $request)
    {
        $validated = $request->validated();
        
        $user = $request->user();
        $user->notification_settings = $request->settings;
        $user->save();
        
        return response()->json(['success' => true, 'message' => 'Settings updated']);
    }
}
