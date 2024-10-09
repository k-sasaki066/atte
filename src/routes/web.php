<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RegisteredUserController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('/register', [RegisteredUserController::class, 'store']);

Route::middleware('auth')->group(function() {
    Route::get('/', [AttendanceController::class, 'index']);
    Route::post('/', [AttendanceController::class, 'create']);
    Route::get('/attendance', [AttendanceController::class, 'date']);
    Route::get('/attendance/date', [AttendanceController::class, 'search']);
    Route::get('/user', [AttendanceController::class, 'indexUser']);
    Route::patch('/user', [AttendanceController::class, 'update']);
    Route::get('/user/search', [AttendanceController::class, 'searchUser']);
    Route::post('/user/search', [AttendanceController::class, 'delete']);
    Route::get('/schedule', [AttendanceController::class, 'schedule']);
    Route::get('/schedule/month', [AttendanceController::class, 'searchSchedule']);
});