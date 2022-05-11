<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/hello",[WeatherController::class,'hello']);
Route::get("/airPollution/{city}/{state}/{country}",[WeatherController::class,'getPollution']);
Route::get("/airPollution/{city}/{state}",[WeatherController::class,'getPollution']);
Route::get("/airPollution/{city}",[WeatherController::class,'getPollution']);
