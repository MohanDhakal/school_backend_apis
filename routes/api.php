<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MajorContactController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ResultsController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use App\Models\MajorContact;
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
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::get('albums', [AlbumController::class, 'index']);
Route::get('/images/album/{id}', [ImageController::class, 'show']);

Route::get('staffs', [StaffController::class, 'index']);
Route::get('staff/all', [StaffController::class, 'all']);

Route::get('staffs/{id}', [StaffController::class, 'show']);
Route::get('staffs/major/contacts', [MajorContactController::class, 'index']);

Route::get('/students', [StudentController::class, 'index']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::get('/students/grade/{grade}', [StudentController::class, 'all']);
Route::get('/files/downloads', [FileController::class, 'download']);
Route::get('/files/{directory}', [FileController::class, 'index']);
Route::post('/files/upload', [FileController::class, 'upload']);
Route::post('/files/delete', [FileController::class, 'deleteFile']);
Route::post('/feedback/add', [FeedbackController::class, 'store']);

Route::get('posts', [PostController::class, 'index']);
Route::get('posts/{id}', [PostController::class, 'show']);
Route::get('posts/user/{id}', [PostController::class, 'author']);

Route::get('/feedbacks', [FeedbackController::class, 'index']);

Route::get('/members', [MemberController::class, 'index']);
Route::post('add/member', [MemberController::class, 'store']);
Route::post('/results/display', [ResultsController::class, 'show_result']);
Route::post('/students/verify', [StudentController::class, 'verify']);
Route::get('/grades', [ClassController::class, 'index']);
Route::get('/student/contact/{id}', [StudentController::class, 'getContact']);
Route::get('/exams', [ExamController::class, 'index']);
Route::get('/exams/years', [ExamController::class, 'getAcademicYear']);
Route::get('/exams/year/{year}', [ExamController::class, 'getExamsForYear']);
Route::get('/events', [EventController::class, 'index']);


// protected routes
Route::middleware('auth:sanctum')->group(function () {

        Route::get('/users', [UserController::class, 'index']);
        Route::get('/user', [UserController::class, 'show']);
        Route::post('/users/logout', [UserController::class, 'logout']);
        
        Route::post('/staffs/add', [StaffController::class, 'store']);
        Route::delete('/staffs/delete/{id}', [StaffController::class, 'destroy']);
        Route::post('/staffs/update/{id}', [StaffController::class, 'update']);
        Route::post('/staffs/major/contact/add', [MajorContactController::class, 'store']);
        Route::delete('/staffs/major/contact/delete/{id}', [MajorContactController::class, 'delete']);

        Route::post('/posts/add', [PostController::class, 'store']);
        Route::delete('posts/delete/{id}', [PostController::class, 'destroy']);
        Route::post('/posts/update/{id}', [PostController::class, 'update']);
        Route::post('/albums/add', [AlbumController::class, 'store']);

        Route::get('/images', [ImageController::class, 'index']);
        Route::post('/images/add', [ImageController::class, 'store']);
        Route::delete('/images/delete/{id}', [ImageController::class, 'destroy']);

        Route::post('/students/add', [StudentController::class, 'store']);
        Route::post('/students/update/{id}', [StudentController::class, 'update']);
        Route::delete('/students/delete/{id}', [StudentController::class, 'destroy']);
        Route::put('/students/update/status/{id}', [StudentController::class, 'toggle']);

        Route::delete('/members/delete/{id}', [MemberController::class, 'destroy']);
        Route::post('/results/add', [ResultsController::class, 'store']);
        Route::post('/results/gpa/add', [ResultsController::class, 'add_gpa']);
        Route::post('/results/update/{id}', [ResultsController::class, 'update']);
        Route::delete('/results/delete/{id}', [ResultsController::class, 'destroy']);

        Route::get('/subjects', [SubjectController::class, 'index']);
        Route::post('/subjects/add', [SubjectController::class, 'store']);
        Route::post('/subjects/update/{id}', [SubjectController::class, 'update']);
        Route::delete('/subjects/delete/{id}', [SubjectController::class, 'destroy']);

        Route::get('/subjects/course/{courseId}', [SubjectController::class, 'getSubjectsFor']);
        Route::get('/subjects/{subjectId}', [SubjectController::class, 'getSubjectDetail']);

        Route::post('/course/add', [CourseController::class, 'store']);
        Route::get('/courses', [CourseController::class, 'index']);
        Route::delete('/course/delete/{id}', [CourseController::class, 'destroy']);

        Route::post('/student/contact/add', [StudentController::class, 'addContact']);
        Route::delete('/student/contact/delete/{id}', [StudentController::class, 'deleteContact']);

        Route::post('/grade/add', [ClassController::class, 'store']);
        Route::delete('/grade/delete/{id}', [ClassController::class, 'destroy']);

        Route::post('/exams/add', [ExamController::class, 'store']);
        Route::delete('/exams/delete/{id}', [ExamController::class, 'destroy']);

        Route::post('/events/add', [EventController::class, 'store']);
        Route::post('/events/update/{id}', [EventController::class, 'update']);
        Route::delete('/events/delete/{id}', [EventController::class, 'delete']);



});
