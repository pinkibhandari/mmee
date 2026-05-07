<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function userExists(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'code' => 422,
                'message' => $validator->errors()->first(),
                'data' => (object) []
            ], 422);
        }
        //  Check user exists
        $user = User::find($request->user_id);
        //  If NOT exists
        if (!$user) {
            return response()->json([
                'status' => false,
                'code' => 422,
                'message' => 'User not found',
                'data' => (object) []
            ]);
        }
        //  If exists
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'User found',
            'data' => $user
        ]);
    }

    public function profile()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'code' =>422,
                'message' => 'Unauthorized',
                'data' => (object) []
            ]);
        }
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'User profile',
            'data' => $user
        ]);
    }

   public function updateProfile(Request $request)
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

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|unique:users,phone,' . $user->id . '|digits:10|regex:/^[6-9]\d{9}$/',
           
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'code' => 422,
                'message' => $validator->errors()->first(),
                'data' => (object) []
            ], 422);
        }

        // Update user profile
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    }


}
