<?php

use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\TeacherController;
use Illuminate\Support\Facades\Route;

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
    return 1;
});



//Route::get('/test-bot', function () {
//    $http = \Illuminate\Support\Facades\Http::get('https://api.telegram.org/bot6114892088:AAHO27RSCo12aYUPwzaiZnSINR41gLOM-8k/setWebhook?url=https://245b-94-137-15-68.ngrok-free.app/webhook');
////    $http = \Illuminate\Support\Facades\Http::get('https://api.telegram.org/bot6114892088:AAHO27RSCo12aYUPwzaiZnSINR41gLOM-8k/getWebhookInfo');
//
//    dd(json_decode($http->body()));
//});

//[\App\Http\Controllers\WebhookController::class, 'index']
//Route::post('/webhook', [\App\Http\Controllers\WebhookController::class, 'index']);

//Route::get('/test-bot-button', function (\App\Helpers\Telegram $telegram) {
//    $buttons = [
//        'inline_keyboard' => [
//            [
//                [
//                    'text' => 'button1',
//                    'callback_data' => '1'
//                ],
//                [
//                    'text' => 'button2',
//                    'callback_data' => '2'
//                ],
//            ],
//            [
//                [
//                    'text' => 'button2',
//                    'callback_data' => '2'
//                ],
//            ]
//        ]
//    ];
//
//    $sendMessage = $telegram->sendButtons(856835272, 'Тестовое сообщение для расписания аххахаха', json_encode($buttons));
//
//    $messageResult = json_decode($sendMessage);
//
//    dd($messageResult);
//});


Route::post('/webhook', [\App\Http\Controllers\WebhookController::class, 'index']);



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

    Route::prefix('schedule')->group(function () {
        Route::get('/', [ScheduleController::class, 'index'])->name('schedule');
        Route::get('/get-data-table', [ScheduleController::class, 'getDataTable']);
        Route::post('/create-schedule', [ScheduleController::class, 'create']);
        Route::post('/edit-schedule', [ScheduleController::class, 'edit']);
    });

    Route::get('/get-basic-data', [\App\Http\Controllers\BasicDataController::class, 'getBasicData']);
});


Auth::routes();

