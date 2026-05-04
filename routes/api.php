<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\ServiceRequestController;


Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/user-exists', [AuthController::class, 'userExists']);

Route::post('/send-otp-email', [PasswordController::class, 'sendOtpEmail']);
Route::post('/reset-password', [PasswordController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function () {
     Route::post('/logout', [AuthController::class, 'logout']); 
     Route::delete('/delete-profile', [AuthController::class, 'deleteProfile']);
     Route::get('/user-profile', [UserController::class, 'profile']);
     Route::post('/update-profile', [UserController::class, 'updateProfile']);
     Route::post('/change-password', [PasswordController::class, 'changePassword']);
     // Attendance Routes
     Route::post('/attendance/mark', [AttendanceController::class, 'markAttendance']);
     Route::get('/attendance/today-status', [AttendanceController::class, 'todayAttendanceStatus']);
     Route::get('/attendance/monthly', [AttendanceController::class, 'monthlyAttendance']);
     // Service Routes
     Route::get('expert/service-request', [ServiceRequestController::class, 'getServiceRequest']);
     Route::get('expert/service-request/{id}', [ServiceRequestController::class, 'show']);

     });
