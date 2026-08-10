<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ConsultantProfile;
use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalUsers = User::where('role', 'client')->count();
        $totalConsultants = User::where('role', 'provider')->count();
        $totalBookings = Booking::count();

        // Platform fee revenue (sum of transactions where type = platform_fee)
        $totalRevenue = Transaction::where('type', 'platform_fee')->sum('amount');

        // Revenue Chart Data (Last 30 days)
        $thirtyDaysAgo = now()->subDays(30);
        
        $chartData = Transaction::where('type', 'platform_fee')
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Fill in missing days
        $filledData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $existing = $chartData->firstWhere('date', $date);
            $filledData[] = [
                'date' => $date,
                'total' => $existing ? (float) $existing->total : 0
            ];
        }

        return response()->json([
            'success' => true,
            'data' => [
                'total_users' => $totalUsers,
                'total_consultants' => $totalConsultants,
                'total_bookings' => $totalBookings,
                'total_revenue' => $totalRevenue,
                'chart_data' => $filledData
            ]
        ]);
    }
}
