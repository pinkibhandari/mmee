<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\PasswordOtp;

class PasswordController extends Controller
{
    public function changePassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).+$/', // requires new_password_confirmation
            ],
            [
                'new_password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }
        $user = auth()->user();
        // check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'code' => 422,
                'status' => false,
                'message' => 'Current password is incorrect',
                'data' => (object) []
            ]);
        }
        // update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Password changed successfully',
            'data' => (object) []
        ]);
    }



    public function sendOtpEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'status' => false,
                'message' => $validator->errors()->first(),
                'data' => (object) []
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'code' => 422,
                'status' => false,
                'message' => 'User not found',
                'data' => (object) []
            ]);
        }

        $otp = rand(100000, 999999);
        PasswordOtp::updateOrCreate(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(10)
            ]
        );
        // Send Email
        Mail::raw("Your OTP is: $otp", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Password Reset OTP');
        });
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'OTP sent to email',
            'data' => (object) []
        ]);
    }



    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:6',
            'new_password' => 'required|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).+$/'
        ],[
                'new_password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.'
            ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'status' => false,
                'message' => $validator->errors()->first(),
                'data' => (object) []
            ], 422);
        }
        $otpRecord = PasswordOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('expires_at', '>=', now())
            ->first();

        if (!$otpRecord) {
            return response()->json([
                'code' => 422,
                'status' => false,
                'message' => 'Invalid or expired OTP',
                'data' => (object) []
            ]);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'code' => 422,
                'status' => false,
                'message' => 'User not found',
                'data' => (object) []
            ]);
        }
        // update password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);
        // delete OTP after success
        PasswordOtp::where('email', $request->email)->delete();
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Password reset successfully',
            'data' => (object) []
        ]);
    }


}
