<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::any("/about",function(Request $request) {
    $name = $request->input('name', 'Nero');
    $age = $request->input('age', '20');
    $school = $request->input('school', 'MiamiUniversity');


    return view('about',['name'=>$name],['school'=>$school],['age'=>$age]);
});
