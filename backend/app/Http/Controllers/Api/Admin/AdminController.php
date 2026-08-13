<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Consultation;
use App\Models\ConsultantProfile;
use App\Models\Transaction;

class AdminController extends Controller
{
    /**
     * Get system statistics.
     */
    public function stats()
    {
        $totalUsers = User::count();
        $totalBookings = Consultation::count();
        $totalRevenue = Transaction::where('type', 'deposit')->where('status', 'success')->sum('amount');
        $disputedBookings = Consultation::where('status', 'disputed')->count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_users' => $totalUsers,
                'total_bookings' => $totalBookings,
                'total_revenue' => $totalRevenue,
                'disputed_bookings' => $disputedBookings,
            ]
        ]);
    }

    /**
     * Get pending or inactive consultant profiles for review.
     */
    public function pendingConsultants()
    {
        $profiles = ConsultantProfile::with('user')
            ->where('is_active', false)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $profiles
        ]);
    }

    /**
     * Toggle the active status of a consultant profile (Approve/Ban).
     */
    public function toggleConsultantStatus($id)
    {
        $profile = ConsultantProfile::with('user')->findOrFail($id);
        
        $profile->is_active = !$profile->is_active;
        $profile->save();

        // If admin approves (is_active becomes true), promote user role to consultant
        if ($profile->is_active && $profile->user->role !== 'admin') {
            $profile->user->role = 'consultant';
            $profile->user->save();
        }

        // Optional: Send email to consultant about their approval/ban status here.

        return response()->json([
            'success' => true,
            'message' => 'Consultant status updated successfully.',
            'data' => [
                'is_active' => $profile->is_active,
                'role' => $profile->user->role
            ]
        ]);
    }
}
