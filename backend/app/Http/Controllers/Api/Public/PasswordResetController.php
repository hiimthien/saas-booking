<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\SendOtpMail;
use App\Http\Requests\SendResetLinkEmailRequest;
use App\Http\Requests\VerifyResetCodeRequest;
use App\Http\Requests\ResetPasswordRequest;

class PasswordResetController extends Controller
{
    public function sendResetLinkEmail(SendResetLinkEmailRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $otp = rand(100000, 999999);
        $cacheKey = 'otp_' . $request->email;
        Cache::put($cacheKey, $otp, now()->addMinutes(5));

        Mail::to($request->email)->send(new SendOtpMail($otp));

        return response()->json(['message' => 'OTP sent successfully']);
    }

    public function verifyResetCode(VerifyResetCodeRequest $request)
    {
        $validated = $request->validated();

        $cacheKey = 'otp_' . $request->email;
        $cachedOtp = Cache::get($cacheKey);

        if ($cachedOtp && $cachedOtp == $request->otp) {
            return response()->json(['message' => 'OTP verified successfully']);
        }

        return response()->json(['message' => 'Invalid or expired OTP'], 400);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $validated = $request->validated();

        $cacheKey = 'otp_' . $request->email;
        $cachedOtp = Cache::get($cacheKey);

        if (!$cachedOtp || $cachedOtp != $request->otp) {
            return response()->json(['message' => 'Invalid or expired OTP'], 400);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
            Cache::forget($cacheKey);

            return response()->json(['message' => 'Password reset successfully']);
        }

        return response()->json(['message' => 'User not found'], 404);
    }
}
