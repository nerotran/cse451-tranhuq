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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/451', function () {
    return view('451');
});

Route::get("/data",function() {
    $data['remote_addr'] = $_SERVER['REMOTE_ADDR'];
    $data['num'] = rand(1,100);

    return view('data',$data);
});
