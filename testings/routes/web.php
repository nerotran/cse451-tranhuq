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

Route::get('/Hello', function () {
    return view('hello', ['name'=>'Nero']);
});

Route::post("/about",function(Request $request) {
    $name = $request->input('name');
    $age = $request->input('age');
    $school = $request->input('school');


    return view('about',['name'=>$name],['age'=>$age],['school'=>$school]);
});
