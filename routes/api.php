<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Home\TimeScheduleController;
use App\Http\Controllers\Home\BusScheduleController;
use App\Http\Controllers\Home\MovieTimeController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Time Schedule
    Route::get('/home-service/show-todolist', [TimeScheduleController::class, 'index']);
    Route::post('/home-service/set-time-schedule', [TimeScheduleController::class, 'store']);

    // Bus Schedule
    Route::get('/home-service/show-busSchedule', [BusScheduleController::class, 'index']);
    Route::post('/home-service/set-bus-schedule', [BusScheduleController::class, 'store']);

    // Bus Schedule
    Route::get('/home-service/show-movie-time', [MovieTimeController::class, 'index']);

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
