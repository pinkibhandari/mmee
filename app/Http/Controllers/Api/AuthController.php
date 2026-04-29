<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserDevice;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:users,phone|digits:10|regex:/^[6-9]\d{9}$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|regex:/^(?=.*[A-Z])(?=.*[0-9]).+$/',
            'emp_id' => 'required|unique:users,emp_id',
            'device_id' => 'required|string',
            'device_type' => 'required|in:android,ios'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'code' => 422,
                'message' => $validator->errors()->first(),
                'data' => (object) []
            ], 422);
        }

        // create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'emp_id' => $request->emp_id,
            'password' => Hash::make($request->password),
        ]);
        $tokenResult = $user->createToken('mobile-token');
        $plainTextToken = $tokenResult->plainTextToken;
        // $tokenId = $tokenResult->accessToken->id ?? null;;
        // store/update device
        UserDevice::updateOrCreate(
            [
                'user_id' => $user->id,
                'device_id' => $request->device_id,
            ],
            [
                'device_type' => $request->device_type,
                // 'token_id' => $tokenId
            ]
        );

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'User signup successful',
            'data' => [
                'token' => $plainTextToken,
                'user' => $user
            ]
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'emp_id' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'code' => 422,
                'message' => $validator->errors()->first(),
                'data' => (object) []
            ], 422);
        }
        // find user
        $user = User::where('emp_id', $request->emp_id)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'code' => 422,
                'message' => 'Invalid emp_id or password',
                'data' => (object) []
            ], 422);
        }
        // create token
        $token = $user->createToken('mobile-token')->plainTextToken;
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Login successful',
            'data' => [
                'token' => $token,
                'user' => $user
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken();
        if ($token) {
            $token->delete();
        }
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Logged out successfully',
            'data' => (object) []
        ]);
    }
    public function deleteProfile()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'code' => 422,
                'message' => 'Unauthorized',
                'data' => (object) []
            ]);
        }
        // Delete tokens (logout from all devices)
        $user->tokens()->delete();
        $user->delete();
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'User deleted successfully',
            'data' => (object) []
        ]);
    }
}
