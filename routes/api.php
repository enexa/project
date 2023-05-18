<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Storage;

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
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::get('/pdf', [PdfController::class, 'index']);
    Route::post('/pdfupload', [PdfController::class, 'store']);

    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user', [AuthController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/announcements', [AnnouncementController::class, 'index']); 
    Route::get('/forums', [ForumController::class, 'index']); 
    Route::post('/forums', [ForumController::class, 'store']); 
    Route::get('/forums/{id}', [ForumController::class, 'show']); 
    Route::put('/forums/{id}', [ForumController::class, 'update']); 
    Route::delete('/forums/{id}', [ForumController::class, 'destroy']); 
    Route::get('/forums/{id}/forum', [ForumController::class, 'index']); 
    Route::post('/forums/{id}/forum', [ForumController::class, 'store']); 
    Route::post('/announcements', [AnnouncementController::class, 'store']); 
    Route::get('/announcements/{id}', [AnnouncementController::class, 'show']); 
    Route::put('/announcements/{id}', [AnnouncementController::class, 'update']); 
    Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy']); 
    Route::get('/announcements/{id}/forum', [ForumController::class, 'index']); 
    Route::post('/announcements/{id}/forum', [ForumController::class, 'store']); 
    Route::put('/forum/{id}', [ForumController::class, 'update']); 
    Route::delete('/forum/{id}', [ForumController::class, 'destroy']); 
    Route::post('/announcements/{id}/likes', [LikeController::class, 'likeOrUnlike']); 
    Route::get('/videos', [VideoController::class, 'index']);
    Route::post('/videos', [VideoController::class, 'store']);
   

Route::get('/pdfs/{category}/{year}', function ($category, $year) {
    $directory = "public/$category/$year";
    $files = Storage::files($directory);

    $pdfUrls = [];

    foreach ($files as $file) {
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $pdfUrls[] = url("temp-pdf/$category/$year/$filename");
    }

    return response()->json($pdfUrls);
});

});

