<?php

use Illuminate\Support\Facades\Route;
require "../vendor/autoload.php";
use GuzzleHttp\Client;

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

Route::get('/about', function () {
    return view('about');
});

Route::get('/451', function () {
    return view('451');
});

Route::get("/data",function() {
    $data['remote_addr'] = $_SERVER['REMOTE_ADDR'];
    $data['num'] = rand(1,100);

    return view('data',$data);
});

Route::get("/remoteinfo",function() {
    $client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://campbest.451.csi.miamioh.edu/rest-laravel.php',
    // You can set any number of default request options.
    'timeout'  => 2.0,
    ]);

    $response = $client->request('GET','');
    $body = json_decode($response->getBody(),true);


    return view('remoteinfo',['time'=>$body["time"]],['remote_addr'=>$body["remote_addr"]]);
});

Route::get("/serverInfo",function() {
    return view('serverinfo',['server'=>$_SERVER]);
});

