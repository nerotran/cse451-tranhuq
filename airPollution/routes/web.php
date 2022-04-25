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
    require_once 'cas.php';
    require "password.php";
    require "todoist.php";

    //type of access we are asking for in todoist
    $scope = "data:read,data:delete";
    
    //if user is asking for logout, remove token
    if (isset($_REQUEST['logout'])) {
      unset($_SESSION['token']);
          }

    //if no token, start oauth process
    if (!isset($_SESSION['token']) || !isset($_SESSION['token-time']) || (time() - $_SESSION['token-time']) > 60) {
      return redirect()->away("https://todoist.com/oauth/authorize?client_id=$clientID&scope=$scope&state=nero");
    }


    $projects = getProjects();

    return view('451',['user'=>$user], ['projects'=>$projects]);
});

Route::get('/todoist', function (Request $request) {

    //this calls in all autoload packages installed via composer
    require '/var/www/html/cse451-tranhuq-web/Todoist/vendor/autoload.php'; 
    require "password.php";

    //base uri -> it is important it end in /
    $uri = "https://todoist.com/oauth/access_token";


    //create a new client
    $client = new Client([
        // Base URI is used with relative requests
        'base_uri' => $uri,
        // You can set any number of default request options.
        'timeout'  => 2.0,
    ]);
    $code = $request->input('code');

    try {
      $data = array("client_id"=>$clientID,"client_secret"=>$client_secret,"code"=>$code,'redirect_uri'=>'https://tranhuq.451.csi.miamioh.edu/cse451-tranhuq-web/Todoist/public/');
      $response = $client->request('POST',"",['form_params'=>$data]);
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

    $_SESSION['token'] = $jbody->access_token;
    $_SESSION['token-time'] = time();
    error_log("todoist code -> got access");

    return redirect("/");

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
