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

Route::post('/forgot-password/send-otp', [App\Http\Controllers\Api\PasswordResetController::class, 'sendOtp']);
Route::post('/forgot-password/verify-otp', [App\Http\Controllers\Api\PasswordResetController::class, 'verifyOtp']);
Route::post('/forgot-password/reset', [App\Http\Controllers\Api\PasswordResetController::class, 'resetPassword']);

Route::prefix('consultants')->group(function () {
    Route::get('/', [ConsultantController::class, 'index']);
    Route::get('/{slug}', [ConsultantController::class, 'show']);
});

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/{id}', [BookingController::class, 'show']);
    Route::post('/payments', [App\Http\Controllers\Api\PaymentController::class, 'process']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::get('/health', function () {
    return response()->json(['status' => 'healthy', 'timestamp' => now()]);
});
