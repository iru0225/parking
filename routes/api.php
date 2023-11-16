<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ParkingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/** Role API */
Route::get('/role', [RoleController::class, 'getRoles']);
Route::get('/role/{id}', [RoleController::class, 'getRole']);
Route::post('/role', [RoleController::class, 'createRole']);

/** User API */
Route::post('/user', [UserController::class, 'createUser']);
Route::post('/login', [UserController::class, 'login']);

/** Parking API */
Route::post('/parking', [ParkingController::class, 'parking'])->middleware('auth:sanctum');
Route::get('/parkings', [ParkingController::class, 'parkings'])->middleware(['auth:sanctum', 'abilities:get-report']);
