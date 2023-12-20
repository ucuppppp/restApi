<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use Illuminate\Auth\Events\Authenticated;
use App\Http\Controllers\AuthenticationController;


Route::middleware(['auth:sanctum'])->group(function () {
    // Logout
    Route::get('/logout', [AuthenticationController::class, 'logout']);
    // Profile
    Route::get('/me', [AuthenticationController::class, 'me']);
    // create
    Route::post('/post', [PostController::class, 'store']);
});

// Melihat postingan
Route::get('/posts', [PostController::class, 'index']);
// Melihat detail postingan
Route::get('/posts/{id}', [PostController::class, 'show']);
// Login
Route::post('/login', [AuthenticationController::class, 'login']);
