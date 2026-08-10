<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ConsultantController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::post('/forgot-password/send-otp', [App\Http\Controllers\Api\PasswordResetController::class, 'sendResetLinkEmail']);
Route::post('/forgot-password/verify-otp', [App\Http\Controllers\Api\PasswordResetController::class, 'verifyResetCode']);
Route::post('/forgot-password/reset', [App\Http\Controllers\Api\PasswordResetController::class, 'resetPassword']);

Route::prefix('consultants')->group(function () {
    Route::get('/', [ConsultantController::class, 'index']);
    Route::get('/{slug}', [ConsultantController::class, 'show']);
});

// Webhooks
Route::post('/webhooks/stripe', [App\Http\Controllers\Api\StripeWebhookController::class, 'handle']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Profiles
    Route::post('/profile/client', [App\Http\Controllers\Api\ProfileController::class, 'updateClientProfile']);
    Route::post('/profile/consultant', [App\Http\Controllers\Api\ProfileController::class, 'updateConsultantProfile']);

    // Extended Client Dashboard
    Route::get('/client/payments', [App\Http\Controllers\Api\ClientDashboardController::class, 'getPayments']);
    Route::get('/client/reviews', [App\Http\Controllers\Api\ClientDashboardController::class, 'getReviews']);
    Route::get('/client/favorites', [App\Http\Controllers\Api\ClientDashboardController::class, 'getFavorites']);
    Route::post('/client/favorites/toggle', [App\Http\Controllers\Api\ClientDashboardController::class, 'toggleFavorite']);
    Route::post('/client/notifications/settings', [App\Http\Controllers\Api\ClientDashboardController::class, 'updateNotificationSettings']);

    // Extended Provider Dashboard
    Route::get('/provider/availabilities', [App\Http\Controllers\Api\AvailabilityController::class, 'index']);
    Route::post('/provider/availabilities', [App\Http\Controllers\Api\AvailabilityController::class, 'update']);
    Route::get('/provider/earnings', [App\Http\Controllers\Api\EarningsController::class, 'index']);

    // Wallets & Transactions (Unified)
    Route::get('/wallet/balance', [App\Http\Controllers\Api\WalletController::class, 'getBalance']);
    Route::get('/wallet/transactions', [App\Http\Controllers\Api\WalletController::class, 'getTransactions']);
    Route::get('/wallet/chart', [App\Http\Controllers\Api\WalletController::class, 'getChartData']);
    Route::post('/wallet/topup', [App\Http\Controllers\Api\WalletController::class, 'topup']);
    Route::post('/wallet/withdraw', [App\Http\Controllers\Api\WalletController::class, 'withdraw']);

    // Bookings
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/{id}', [BookingController::class, 'show']);
    Route::post('/payments', [App\Http\Controllers\Api\PaymentController::class, 'process']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

// Admin Routes
Route::middleware(['auth:sanctum', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Api\AdminDashboardController::class, 'index']);
    
    Route::get('/users', [App\Http\Controllers\Api\AdminUserController::class, 'index']);
    Route::post('/users/{id}/toggle-ban', [App\Http\Controllers\Api\AdminUserController::class, 'toggleBan']);
    
    Route::get('/consultants/pending', [App\Http\Controllers\Api\AdminConsultantController::class, 'pending']);
    Route::post('/consultants/{id}/approve', [App\Http\Controllers\Api\AdminConsultantController::class, 'approve']);
    Route::post('/consultants/{id}/reject', [App\Http\Controllers\Api\AdminConsultantController::class, 'reject']);
    
    Route::get('/transactions', [App\Http\Controllers\Api\AdminTransactionController::class, 'index']);
    Route::post('/transactions/{id}/approve', [App\Http\Controllers\Api\AdminTransactionController::class, 'approve']);
});

Route::get('/health', function () {
    return response()->json(['status' => 'healthy', 'timestamp' => now()]);
});
