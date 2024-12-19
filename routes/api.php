<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Middleware\AuthMiddleware;
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

Route::prefix('/v1/auth')->group(function(){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware([AuthMiddleware::class])->prefix('/v1/board')->group(function (){
    Route::get('', [BoardController::class, 'index']);
    Route::get('/{id}', [BoardController::class, 'show']);
    Route::post('', [BoardController::class, 'create']);
    Route::post('/{id}', [BoardController::class, 'create']);
    Route::put('/{id}', [BoardController::class, 'update']);
    Route::delete('/{id}', [BoardController::class, 'destroy']);
});
