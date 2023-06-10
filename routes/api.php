<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ScheduleController;


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
    Route::post('/pdfupload', [PdfController::class, 'add']);
    Route::get('/storage/{category}/{year}/{filename}',  [PdfController::class, 'index'])->name('pdf.show');
Route::get('/temp-pdf/{category}/{year}/{filename}', function ($category, $year, $filename) {
    $filePath = storage_path("app/public/$category/$year/$filename");
    return response()->file($filePath);
});
Route::get('/schedules', [ScheduleController::class, 'index']);
Route::post('/schedules', [ScheduleController::class, 'createSchedule']);
Route::put('/schedules/{id}', [ScheduleController::class, 'updateSchedule']);
Route::delete('/schedules/{id}', [ScheduleController::class, 'deleteSchedule']);
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{course}', [CourseController::class, 'show']);
    Route::post('/courses', [CourseController::class, 'store']);
    Route::post('/courses/{title}/enroll', [CourseController::class, 'enroll']);
   
    Route::get('/teacher/courses', [CourseController::class, 'teacherCourses']);
    Route::get('/teacher/courses/{course}/students', [CourseController::class, 'courseStudents']);
    Route::get('/courses/{course}/videos', [CourseController::class, 'courseVideos']);

//
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
    //new
     Route::get('/forums/{id}/comments', [CommentController::class, 'index']); // all comments of a post
    Route::post('/forums/{id}/comments', [CommentController::class, 'store']); // create comment on a post
    Route::put('/comments/{id}', [CommentController::class, 'update']); // update a comment
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']); // delete a comment

    // Like
    Route::post('/forums/{id}/likes', [LikeController::class, 'likeOrUnlike']); 
   

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
Route::middleware('auth:api', 'teacher')->group(function () {
    Route::get('/teacher/courses', [CourseController::class, 'teacherCourses']);
    Route::get('/teacher/courses/{course}/students', [CourseController::class, 'courseStudents']);
    Route::get('/courses/{title}/enrolled-students', [CourseController::class, 'enrolledStudents']);
});



