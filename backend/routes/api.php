<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::prefix('')->namespace('App\Http\Controllers\Api\Public')->group(function () {
    Route::post('/register', 'AuthController@register')->middleware('throttle:auth');
    Route::post('/login', 'AuthController@login')->middleware('throttle:auth');
    
    // Auth Google
    Route::get('/auth/google', 'AuthController@redirectToGoogle');
    Route::get('/auth/google/callback', 'AuthController@handleGoogleCallback');

    // Xem danh sách chuyên gia & đặt lịch rảnh
    Route::get('/consultants', 'ConsultantController@index');
    Route::get('/consultants/{slug}', 'ConsultantController@show');
    Route::get('/consultants/{id}/available-slots', 'ConsultantController@availableSlots');

    // Webhook thanh toán
    Route::post('/webhooks/stripe', 'StripeWebhookController@handle');
});

// Authenticated Routes
Route::middleware('auth:sanctum')->group(function () {
    
    // API đăng xuất chung
    Route::post('/logout', 'App\Http\Controllers\Api\Public\AuthController@logout');

    // Admin Routes
    Route::middleware('is_admin')->prefix('admin')->namespace('App\Http\Controllers\Api\Admin')->group(function () {
        Route::get('/stats', 'AdminController@stats');
        Route::get('/consultants/pending', 'AdminController@pendingConsultants');
        Route::post('/consultants/{id}/toggle-status', 'AdminController@toggleConsultantStatus');
    });

    // Customer Routes
    Route::middleware('is_customer')->namespace('App\Http\Controllers\Api\Customer')->group(function () {
        Route::post('/profile/client', 'CustomerProfileController@updateClientProfile');
        Route::post('/become-consultant', 'CustomerProfileController@becomeConsultant');

        Route::prefix('customer')->group(function () {
            Route::get('/dashboard/stats', 'ClientDashboardController@getStats');
            Route::get('/bookings', 'ClientDashboardController@getBookings');
        });

        Route::post('/bookings', 'BookingController@store')->middleware('throttle:booking');
        Route::post('/bookings/{id}/cancel', 'BookingController@cancel');
        Route::post('/bookings/{id}/report', 'BookingController@report');
        
        Route::post('/bookings/{id}/reviews', 'ReviewController@store');
        Route::put('/reviews/{id}', 'ReviewController@update');
        Route::delete('/reviews/{id}', 'ReviewController@destroy');
        
        Route::post('/payments', 'PaymentController@process');
    });

    // Consultant Routes
    Route::middleware('is_consultant')->namespace('App\Http\Controllers\Api\Consultant')->group(function () {
        Route::post('/profile/consultant', 'ConsultantProfileController@updateConsultantProfile');
        
        Route::prefix('consultant')->group(function () {
            Route::post('/working-hours', 'WorkingHourController@store');
            Route::get('/working-hours', 'WorkingHourController@index');
            Route::delete('/working-hours/{id}', 'WorkingHourController@destroy');

            Route::get('/dashboard/stats', 'ConsultantDashboardController@getStats');
            Route::get('/bookings', 'ConsultantDashboardController@getBookings');

            Route::get('/wallet', 'WalletController@balance');
            Route::post('/wallet/payout', 'WalletController@requestPayout');
        });
    });

    // Profile chung
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
