<?php

use App\Http\Controllers\Api\v1\AdminController;
use App\Http\Controllers\Api\v1\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/v1')->group(function () {
    Route::prefix('/user')->group(function () {
        Route::get('/', [UserController::class, 'findAll']);
        Route::get('/{id}', [UserController::class, 'findById']);
        Route::post('/', [UserController::class, 'create']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'delete']);
    });
    Route::prefix('/admin')->group(function () {
        Route::get('/', [AdminController::class, 'findAll']);
        Route::get('/{id}', [AdminController::class, 'findById']);
        Route::post('/', [AdminController::class, 'create']);
        Route::put('/{id}', [AdminController::class, 'update']);
        Route::delete('/{id}', [AdminController::class, 'delete']);
    });
});
