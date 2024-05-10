<?php

use App\Http\Controllers\ChatController; //import this
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard',[ChatController::class,'loadDashboard'])
->middleware(['auth', 'verified'])
->name('dashboard');

Route::get('/check-channel',[ChatController::class,'CheckChannel'])->middleware(['auth', 'verified']);
Route::get('/create-channel',[ChatController::class,'CreateChannel'])->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
