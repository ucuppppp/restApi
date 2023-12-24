<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use Illuminate\Auth\Events\Authenticated;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthenticationController;


Route::middleware(['auth:sanctum'])->group(function () {
    // Logout
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    // Profile
    Route::get('/me', [AuthenticationController::class, 'me']);
    // create
    Route::post('/post', [PostController::class, 'store']);
    // update
    Route::patch('/post/{id}', [PostController::class, 'update'])->middleware('postOwner');
    // delete
    Route::delete('post/{id}', [PostController::class, 'destroy'])->middleware('postOwner');
    // comment
    Route::post('/comment', [CommentController::class, 'store']);
    // edit comment
    Route::patch('/comment/{id}', [CommentController::class, 'update'])->middleware('commentOwner');
    // delete comment
    Route::delete('comment/{id}', [CommentController::class, 'destroy'])->middleware('commentOwner');
});

// Login
Route::post('/login', [AuthenticationController::class, 'login']);
// Melihat postingan
Route::get('/posts', [PostController::class, 'index']);
// Melihat detail postingan
Route::get('/post/{id}', [PostController::class, 'show']);
// Melihat postingan sesuai author nya
Route::get('/author/{id}/posts', [PostController::class, 'authorPost']);


