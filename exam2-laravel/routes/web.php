<?php

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
date_default_timezone_set("America/New_York");

Route::get('/', function () {
    return view('welcome');
});

Route::get('/time', function () {
    $time = date("h:i:s a", time());
    return view('time', $time);
});

Route::get('/random', function () {
    $retdata = array();
    $retdata["status"] = "ok";
    $retdata["msg"] = "";
    $retdata["random"] = rand();

    print json_encode($retdata);
    exit;
});
