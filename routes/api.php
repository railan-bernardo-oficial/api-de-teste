<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post("/auth", [AuthController::class, 'auth'])->name('auth');
Route::get("/login", [AuthController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {

    //users
    Route::post("/users", [UserController::class, 'store']);
    Route::post("/user/{id}", [UserController::class, 'edit']);
    Route::get("/user/{id}", [UserController::class, 'destroy']);
    Route::get("/users", [UserController::class, 'index']);

    //category
    Route::post('category', [CategoryController::class, 'store']);
    Route::post('category/{id}', [CategoryController::class, 'edit']);
    Route::get('category/{id}', [CategoryController::class, 'destroy']);
    Route::get('category', [CategoryController::class, 'index']);


    //vehicles
    Route::post('vehicle', [VehicleController::class, 'store']);
    Route::post('vehicle/{id}', [VehicleController::class, 'edit']);
    Route::get('vehicle/{id}', [VehicleController::class, 'destroy']);
    Route::get('vehicle', [VehicleController::class, 'index']);
});
