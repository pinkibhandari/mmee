<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\TaskManagement;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
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
    });

});

require __DIR__.'/auth.php';