<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
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

//public routes
Route::post('/register', [UserController::class,'register']);
Route::post('/login', [UserController::class,'login']);

Route::get('albums', [AlbumController::class,'index']);
Route::get('/images/album/{id}', [ImageController::class,'show']);

Route::get('staffs', [StaffController::class,'index']);
Route::get('staffs/{id}', [StaffController::class,'show']);

Route::get('/students', [StudentController::class,'index']);      
Route::get('/students/{id}', [StudentController::class,'show']);
Route::get('/students/grade/{grade}', [StudentController::class,'all']);  

Route::get('/files/downloads', [FileController::class,'download']);      
Route::get('/files/{directory}', [FileController::class,'index']);      
Route::post('/feedback/add', [FeedbackController::class, 'store']);
Route::get('/feedback', [FeedbackController::class, 'index']);

Route::get('posts', [PostController::class,'index']);
Route::get('posts/{id}', [PostController::class,'show']);       
Route::get('posts/user/{id}', [PostController::class,'author']);       

// protected routes
Route::middleware('auth:sanctum')->group(function () {

        Route::get('/users', [UserController::class, 'index']);
        Route::get('/user', [UserController::class, 'show']);
        Route::post('/users/logout', [UserController::class, 'logout']);
        
        Route::post('/staffs/add',[StaffController::class,'store']);
        Route::delete('/staffs/delete/{id}',[StaffController::class,'destroy']);
        Route::post('/staffs/update/{id}',[StaffController::class,'update']);

        Route::post('/posts/add',[PostController::class,'store']);
        Route::delete('posts/delete/{id}',[PostController::class,'destroy']);
        Route::post('/posts/update/{id}',[PostController::class,'update']);

        Route::post('/albums/add',[AlbumController::class,'store']);
      
        Route::get('/images', [ImageController::class,'index']);
        Route::post('/images/add', [ImageController::class,'store']);
        Route::delete('/images/delete/{id}',[ImageController::class,'destroy']);

        Route::post('/students/add',[StudentController::class,'store']);
        Route::delete('/students/delete/{id}',[StudentController::class,'destroy']);
        

});

