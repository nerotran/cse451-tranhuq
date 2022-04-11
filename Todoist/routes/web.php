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
session_start();
require "password.php";


//type of access we are asking for in todoist
$scope = "data:read,data:delete";


Route::get('/', function () {
    require_once 'cas.php';
    require "todoist.php";
    global $clientID, $client_secret;

    //type of access we are asking for in todoist
    $scope = "data:read,data:delete";

    session_start();
    //if user is asking for logout, remove token
    if (isset($_REQUEST['logout'])) {
      unset($_SESSION['token']);
          }

    //if no token, start oauth process
    if (!isset($_SESSION['token']) || !isset($_SESSION['token-time']) || (time() - $_SESSION['token-time']) > 60) {
      header("Location: https://todoist.com/oauth/authorize?client_id=$clientID&scope=$scope&state=nero");


    $projects = getProjects();

    return view('451',['user'=>$user], $projects);
});

Route::get('/todoist', function () {

    //this calls in all autoload packages installed via composer
    require __DIR__ . '../vendor/autoload.php'; 
    require "password.php";

    //bring guzzle client into code
    use GuzzleHttp\Client;

    //base uri -> it is important it end in /
    $uri = "https://todoist.com/oauth/access_token";


    //create a new client
    $client = new Client([
        // Base URI is used with relative requests
        'base_uri' => $uri,
        // You can set any number of default request options.
        'timeout'  => 2.0,
    ]);
     $code =htmlspecialchars($_REQUEST['code']);

    try {
      $data = array("client_id"=>$clientID,"client_secret"=>$clientSecret,"code"=>$code,'redirect_uri'=>'https://tranhuq.451.csi.miamioh.edu/cse451-tranhuq-web/Todoist/public/');
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

    header("location: index.php");

});
