<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;


Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/user-exists', [AuthController::class, 'userExists']);

// Route::post('/send-otp', [AuthController::class, 'sendOtp']);
// Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
// Route::post('/reset-password', [AuthController::class, 'resetPasswordWithOtp']);

Route::middleware('auth:sanctum')->group(function () {
     Route::post('/logout', [AuthController::class, 'logout']); 
     Route::delete('/delete-profile', [AuthController::class, 'deleteProfile']);
     Route::get('/user-profile', [UserController::class, 'profile']);
     Route::post('/update-profile', [UserController::class, 'updateProfile']);
     

     });
