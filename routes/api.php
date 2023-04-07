<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\LikeController;


Route::post('/register', [AuthController::class, 'registerStudent']);
Route::post('/register-teacher', [UserController::class, 'registerTeacher'])->middleware('auth:api');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/teacher-login', [AuthController::class, 'teacherLogin']);
Route::get('/list-teachers', [UserController::class, 'listTeachers'])->middleware('auth:api');
Route::get('list-students', [UserController::class, 'listStudents'])->middleware('auth:api');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user', [AuthController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/announcements', [AnnouncementController::class, 'index']); 
    Route::post('/announcements', [AnnouncementController::class, 'store']); 
    Route::get('/announcements/{id}', [AnnouncementController::class, 'show']); 
    Route::put('/announcements/{id}', [AnnouncementController::class, 'update']); 
    Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy']); 
    Route::get('/announcements/{id}/forum', [ForumController::class, 'index']); 
    Route::post('/announcements/{id}/forum', [ForumController::class, 'store']); 
    Route::put('/forum/{id}', [ForumController::class, 'update']); 
    Route::delete('/forum/{id}', [ForumController::class, 'destroy']); 
    Route::post('/announcements/{id}/likes', [LikeController::class, 'likeOrUnlike']); 
});

