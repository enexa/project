<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/storage/{category}/{year}/{filename}',  [PdfController::class, 'index'])->name('pdf.show');
Route::get('/temp-pdf/{category}/{year}/{filename}', function ($category, $year, $filename) {
    $filePath = storage_path("app/public/$category/$year/$filename");
    return response()->file($filePath);
});




Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'index'])->name('index');
    Route::get('/pdfupload', [\App\Http\Controllers\AdminController::class, 'pdfupload'])->name('pdf.upload');
    Route::get('/create-teacher', [\App\Http\Controllers\AdminController::class, 'createTeacher'])->name('create.teacher');
    Route::post('/store-teacher', [\App\Http\Controllers\AdminController::class, 'storeTeacher'])->name('store.teacher');
    Route::get('/list-students', [\App\Http\Controllers\AdminController::class, 'listStudents'])->name('list.students');
    Route::get('/list-teachers', [\App\Http\Controllers\AdminController::class, 'listTeachers'])->name('list.teachers');
    Route::get('/teachers/edit/{id}', 'TeacherController@edit')->name('edit.teacher');
    Route::delete('/delete-student/{student}', [\App\Http\Controllers\AdminController::class, 'destroyStudent'])->name('delete.student');
    Route::delete('/delete-teacher/{teacher}', [\App\Http\Controllers\AdminController::class, 'destroyTeacher'])->name('delete.teacher');
   
    Route::post('/pdfadd', [\App\Http\Controllers\AdminController::class, 'pdfadd'])->name('pdf.add');
    


  







});
Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');