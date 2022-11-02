<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/car/my', [CarController::class, 'my']);
    Route::put('/car/change', [CarController::class, 'change']);
    Route::put('/car/cancel', [CarController::class, 'cancel']);
    Route::put('/car/book', [CarController::class, 'book']);
});

Route::get('/car/free', [CarController::class, 'free']);
Route::get('/car/all', [CarController::class, 'all']);
