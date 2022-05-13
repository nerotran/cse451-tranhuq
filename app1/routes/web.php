<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
require "vendor/autoload.php";
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
    if (Cache::has("title")) {
        $title = Cache::get("title");
    } else {
        $title = "NOT SET";
    }

    if (Cache::has("author")) {
        $author = Cache::get("author");
    } else {
        $author = "NOT SET";
    }
    return view('Final',['author' => $author],['title' => $title]);
});

Route::get('/form', function () {
    return view('form');
});

Route::any('/data', function (Request $request) {
    $title = $request->input('title');
    $author = $request->input('author');
    if (isset($title) && isset($author)) {
        Cache::put("title",$title,$seconds=60);
        Cache::put("author",$author,$seconds=60);
    }

    return redirect('/');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/451', function () {
    return view('451');
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

Route::get("/key",function() {
    $data = DB::table('data')->get();

    return view('key',['data'=>$data]);
});

Route::any("/key/update",function(Request $request) {
    $key = $request->input('key',"Hello");
    $value = $request->input('value',"scott");

    $cnt = DB::table('data')->where('key',$key)->first();
    if (isset($cnt->value))
    {
        DB::table('data')->where('key',$key)->update(['value'=>$value]);
    }       
    else
    {
        DB::table('data')->insert([
        'key'=>$key,'value'=>$value]);
    }

    DB::table('data')->where('key',$key)->update(['value'=>$value]);

    return view('update');
});

Route::get("/keyClear",function(Request $request) {
    $password = $request->input('password',"");

    if ($password == "clear") {
        DB::table('data')->truncate();
    }

    return view('keyClear');
});