<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\WasherController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\BookingNotificationController;
use App\Http\Controllers\AgentController;

// Public routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});
use App\Http\Controllers\BookingController;

Route::apiResource('bookings', BookingController::class);


// Protected routes
Route::middleware('auth:sanctum')->prefix('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
});
//Booking
Route::middleware('auth:sanctum')->prefix('bookings')->group(function () {
    Route::get('/', [BookingController::class, 'index']);
    Route::post('/', [BookingController::class, 'store']);
    Route::get('/{id}', [BookingController::class, 'show']);
    Route::put('/{id}', [BookingController::class, 'update']);
    Route::delete('/{id}', [BookingController::class, 'destroy']);
});

// SLOTS
Route::get('/slots', [SlotController::class, 'index']);
Route::post('/slots', [SlotController::class, 'store']);
Route::get('/slots/{id}', [SlotController::class, 'show']);
Route::put('/slots/{id}', [SlotController::class, 'update']);
Route::delete('/slots/{id}', [SlotController::class, 'destroy']);
Route::post('slots/bulk', [SlotController::class, 'storeBulk']);

// WASHERS
Route::get('/washers', [WasherController::class, 'index']);
Route::post('/washers', [WasherController::class, 'store']);
Route::get('/washers/{id}', [WasherController::class, 'show']);
Route::put('/washers/{id}', [WasherController::class, 'update']);
Route::delete('/washers/{id}', [WasherController::class, 'destroy']);

// REGIONS
Route::get('/regions', [RegionController::class, 'index']);
Route::post('/regions', [RegionController::class, 'store']);
Route::get('/regions/{id}', [RegionController::class, 'show']);
Route::put('/regions/{id}', [RegionController::class, 'update']);
Route::delete('/regions/{id}', [RegionController::class, 'destroy']);

// Agents CRUD
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/agents', [AgentController::class, 'index']);
    Route::post('/agents', [AgentController::class, 'store']);
    Route::get('/agents/{id}', [AgentController::class, 'show']);
    Route::put('/agents/{id}', [AgentController::class, 'update']);
    Route::delete('/agents/{id}', [AgentController::class, 'destroy']);
});

// POST route to send booking email
Route::post('booking-notifications', [BookingNotificationController::class, 'sendBookingEmail']);

