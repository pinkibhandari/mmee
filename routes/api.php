<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\TaskLogController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\CmsPageController;
use App\Http\Controllers\Api\HomeController;



Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/user-exists', [AuthController::class, 'userExists']);

Route::post('/send-otp-email', [PasswordController::class, 'sendOtpEmail']);
Route::post('/reset-password', [PasswordController::class, 'resetPassword']);
//  cms page route
Route::get('/cms-page/{slug}', [CmsPageController::class, 'cmsPage']);

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
     //employee task log routes
     Route::post('/start-job', [TaskLogController::class, 'startJob']);
     Route::post('/check-in', [TaskLogController::class, 'checkIn']);
     Route::post('/work-start', [TaskLogController::class, 'workStart']);
     Route::post('/work-end', [TaskLogController::class, 'workEnd']);
     Route::post('/check-out', [TaskLogController::class, 'checkOut']);
     Route::get('/employee-task-list', [TaskLogController::class, 'employeeTaskList']);

     //  task list route
     Route::get('/task-list', [TaskController::class, 'taskList']);
     Route::get('/task/{id}', [TaskController::class, 'taskDetails']);
     //home page route
     Route::get('/home', [HomeController::class, 'homePage']);
 
 });
