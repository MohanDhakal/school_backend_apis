<?php

use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\AuthenticationException;
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


Route::post('/register', [UserController::class,'register']);
Route::post('/login', [UserController::class,'login']);

Route::middleware('auth:sanctum','auth.token.expiration')->group(function () {
        Route::apiResource('/users',UserController::class);
        Route::get('/users/{id}', [UserController::class, 'show']);
    
        Route::apiResource('/staffs',StaffController::class);
        Route::get('staffs/{id}', [StaffController::class,'show']);
        Route::post('/staffs/add',[StaffController::class,'store']);
    
});

