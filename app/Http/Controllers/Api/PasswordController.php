<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed| regex:/^(?=.*[A-Z])(?=.*[0-9]).+$/', // requires new_password_confirmation
        ]);

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
                'data'=>(object)[]
            ]);
        }
        // update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'code'=> 200,
            'status' => true,
            'message' => 'Password changed successfully',
            'data' => (object)[]
        ]);
    }
}
