<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Public\AuthController;
use App\Http\Controllers\Api\Public\ConsultantController;
use App\Http\Controllers\Api\Public\PasswordResetController;
use App\Http\Controllers\Api\Public\StripeWebhookController;

use App\Http\Controllers\Api\Customer\BookingController;
use App\Http\Controllers\Api\Customer\ClientDashboardController;
use App\Http\Controllers\Api\Customer\CustomerProfileController;
use App\Http\Controllers\Api\Customer\NotificationController;
use App\Http\Controllers\Api\Customer\PaymentController;
use App\Http\Controllers\Api\Customer\ReviewController;

use App\Http\Controllers\Api\Consultant\ConsultantProfileController;
use App\Http\Controllers\Api\Consultant\WalletController;

use App\Http\Controllers\Api\AvailabilityController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\EarningsController;

use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\AdminDashboardController;
use App\Http\Controllers\Api\AdminUserController;
use App\Http\Controllers\Api\AdminConsultantController;
use App\Http\Controllers\Api\AdminTransactionController;

// ==========================================
// Public Routes
// ==========================================
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:auth');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:auth');

// Auth Google
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// Quên mật khẩu OTP
Route::post('/forgot-password/send-otp', [PasswordResetController::class, 'sendResetLinkEmail']);
Route::post('/forgot-password/verify-otp', [PasswordResetController::class, 'verifyResetCode']);
Route::post('/forgot-password/reset', [PasswordResetController::class, 'resetPassword']);

// Danh sách & chi tiết chuyên gia
Route::prefix('consultants')->group(function () {
    Route::get('/', [ConsultantController::class, 'index']);
    Route::get('/{slug}', [ConsultantController::class, 'show']);
    Route::get('/{id}/available-slots', [ConsultantController::class, 'availableSlots']);
});

// Webhook thanh toán Stripe
Route::post('/webhooks/stripe', [StripeWebhookController::class, 'handle']);

// ==========================================
// Authenticated Routes
// ==========================================
Route::middleware('auth:sanctum')->group(function () {
    
    // Đăng xuất
    Route::post('/logout', [AuthController::class, 'logout']);

    // Profile người dùng hiện tại
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Profile Cập nhật
    Route::post('/profile/client', [CustomerProfileController::class, 'updateClientProfile']);
    Route::post('/profile/consultant', [ConsultantProfileController::class, 'updateConsultantProfile']);
    Route::post('/become-consultant', [CustomerProfileController::class, 'becomeConsultant']);

    // Bookings (Dùng chung cho cả Client & Provider)
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store'])->middleware('throttle:booking');
    Route::get('/bookings/{id}', [BookingController::class, 'show']);
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel']);
    Route::post('/bookings/{id}/report', [BookingController::class, 'report']);
    Route::post('/bookings/{id}/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{id}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);

    // Thông báo (Notification Center)
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);

    // Tin nhắn & Trò chuyện (In-App Live Chat)
    Route::get('/conversations', [ChatController::class, 'index']);
    Route::post('/conversations/start', [ChatController::class, 'startConversation']);
    Route::get('/conversations/{id}/messages', [ChatController::class, 'messages']);
    Route::post('/conversations/{id}/messages', [ChatController::class, 'sendMessage']);

    // Thanh toán
    Route::post('/payments', [PaymentController::class, 'process']);

    // Ví tiền & Giao dịch (Dùng chung cho Client nạp tiền & Provider rút tiền)
    Route::get('/wallet/balance', [WalletController::class, 'getBalance']);
    Route::get('/wallet/transactions', [WalletController::class, 'getTransactions']);
    Route::get('/wallet/chart', [WalletController::class, 'getChartData']);
    Route::post('/wallet/topup', [WalletController::class, 'topup']);
    Route::post('/wallet/withdraw', [WalletController::class, 'withdraw']);

    // Client Dashboard Sub-routes
    Route::get('/client/payments', [ClientDashboardController::class, 'getPayments']);
    Route::get('/client/reviews', [ClientDashboardController::class, 'getReviews']);
    Route::get('/client/favorites', [ClientDashboardController::class, 'getFavorites']);
    Route::post('/client/favorites/toggle', [ClientDashboardController::class, 'toggleFavorite']);
    Route::post('/client/notifications/settings', [ClientDashboardController::class, 'updateNotificationSettings']);

    Route::prefix('customer')->group(function () {
        Route::get('/dashboard/stats', [ClientDashboardController::class, 'getStats']);
        Route::get('/bookings', [ClientDashboardController::class, 'getBookings']);
    });

    // Provider / Consultant Dashboard
    Route::get('/provider/availabilities', [AvailabilityController::class, 'index']);
    Route::post('/provider/availabilities', [AvailabilityController::class, 'update']);
    Route::get('/provider/earnings', [EarningsController::class, 'index']);

    Route::prefix('consultant')->group(function () {
        Route::get('/working-hours', [AvailabilityController::class, 'index']);
        Route::post('/working-hours', [AvailabilityController::class, 'update']);
        Route::get('/wallet', [WalletController::class, 'getBalance']);
        Route::post('/wallet/payout', [WalletController::class, 'withdraw']);
        Route::get('/bookings', [BookingController::class, 'index']);
    });

    // Admin Routes
    Route::middleware('is_admin')->prefix('admin')->group(function () {
        Route::get('/stats', [AdminController::class, 'stats']);
        Route::get('/dashboard', [AdminDashboardController::class, 'index']);

        Route::get('/users', [AdminUserController::class, 'index']);
        Route::post('/users/{id}/toggle-ban', [AdminUserController::class, 'toggleBan']);

        Route::get('/consultants/pending', [AdminConsultantController::class, 'pending']);
        Route::post('/consultants/{id}/approve', [AdminConsultantController::class, 'approve']);
        Route::post('/consultants/{id}/reject', [AdminConsultantController::class, 'reject']);
        Route::post('/consultants/{id}/toggle-status', [AdminController::class, 'toggleConsultantStatus']);

        Route::get('/transactions', [AdminTransactionController::class, 'index']);
        Route::post('/transactions/{id}/approve', [AdminTransactionController::class, 'approve']);
    });
});

Route::get('/health', function () {
    return response()->json(['status' => 'healthy', 'timestamp' => now()]);
});
