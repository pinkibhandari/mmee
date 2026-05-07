<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\{TaskManagement, RoleController, PermissionController, ServiceController, SiteController, UserController};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/dashboard', function () {
    return view('admin.home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ✅ FIX: admin routes inside auth
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('tasks', TaskManagement::class);
        Route::resource('services', ServiceController::class);
        Route::resource('sites', SiteController::class);

        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
    });
});

require __DIR__ . '/auth.php';
