<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/admin/register', [\App\Http\Controllers\UserController::class, 'index']);

Route::get('/home', function () {
//    dd('Авторизовались');
    return 1;
});

Route::middleware('admin')->group(function () {
    Route::get('/admin', [\App\Http\Controllers\Admin\AdminController::class, 'index'])
        ->name('admin');

    Route::prefix('teachers')->group(function () {
        Route::get('/', [TeacherController::class, 'index'])
            ->name('teachers');
        Route::get('/get-data-table', [TeacherController::class, 'getDataTable']);
        Route::get('/get-teacher/{id}', [TeacherController::class, 'getTeacher']);
        Route::post('/add-teacher', [TeacherController::class, 'create']);
        Route::post('/edit-teacher', [TeacherController::class, 'edit']);
        Route::post('/delete-teacher', [TeacherController::class, 'delete']);
    });
});


Auth::routes();

