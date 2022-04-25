<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\TaskController;
//bring guzzle client into code
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
session_start();


Route::get('/', function () {

    return view('airPollution');
});

Route::get('/buildings', function () {

    //this calls in all autoload packages installed via composer
    require '/var/www/html/cse451-tranhuq-web/Buildings/vendor/autoload.php';
    $uri = "http://ws.miamioh.edu/api/building/v1"; 

    //create a new client
    $client = new Client([
        // Base URI is used with relative requests
        'base_uri' => $uri,
        // You can set any number of default request options.
        'timeout'  => 2.0,
    ]);

    try {
      $response = $client->request('GET',"");
    } catch (Exception $e) {
      print "There was an error getting the token from todoist";
    //  header("content-type: text/plain",true);
     // print_r($e);
      $a=print_r($e,true);
      error_log($a);
      exit;
    }
    $body = (string) $response->getBody();
    $jbody = json_decode($body);
    if (!$jbody) {
      error_log("no json");
      exit;
    }

    return view('buildings', ['buildings'=>$jbody]);

})->middleware('cas.auth');

Route::get('/weather', function () {

    return redirect("/index.php/api/temp");

})->middleware('cas.auth');

Route::get("/task/{id}", [TaskController::class, "show"]);
