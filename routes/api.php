<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServiceRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// CSRF
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

// Authentication routes
Route::prefix('auth')->middleware('api')->controller(AuthController::class)->group(function () {
    Route::post('/login', 'login'); // Public
    Route::post('/register', 'register'); // Public
    Route::middleware('auth:sanctum')->post('/logout', 'logout'); // Logged-in users
});

// Users routes
Route::prefix('users')->middleware('api')->controller(UserController::class)->group(function () {
    Route::middleware('role:admin')->get('/', 'index'); // Only admins
});

// Workshops routes
Route::prefix('workshops')->middleware('api')->controller(WorkshopController::class)->group(function () {
    Route::get('/', 'index'); // Public
    Route::get('/{id}', 'show'); // Public
    Route::middleware('role:mechanic,admin')->post('/', 'store'); // Mechanics and admins
});

// Services routes
Route::prefix('services')->middleware('api')->controller(ServiceController::class)->group(function () {
    Route::get('/', 'index'); // Public
    Route::get('/{id}', 'show'); // Public
    Route::middleware('role:admin')->post('/', 'store'); // Only admins
});

// Reviews routes
Route::prefix('reviews')->middleware('api')->controller(ReviewController::class)->group(function () {
    Route::get('/', 'index'); // Public
    Route::middleware('auth:sanctum')->post('/', 'store'); // Logged-in users
});

// Service Requests routes
Route::prefix('service-requests')->middleware('api')->controller(ServiceRequestController::class)->group(function () {
    Route::middleware('role:mechanic,admin')->get('/', 'index'); // Mechanics and admins
    Route::middleware('role:mechanic,admin')->get('/{id}', 'show'); // Mechanics and admins
    Route::middleware('role:customer')->post('/', 'store'); // Clients
    Route::middleware('role:mechanic,admin')->patch('/{id}', 'update'); // Mechanics and admins
});
