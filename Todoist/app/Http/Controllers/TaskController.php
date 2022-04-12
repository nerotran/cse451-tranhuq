<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//bring guzzle client into code
use GuzzleHttp\Client;

class TaskController extends Controller
{
    public function show($id)
    {
        require '/var/www/html/cse451-tranhuq-web/Todoist/vendor/autoload.php'; 
        require "/var/www/html/cse451-tranhuq-web/Todoist/routes/password.php";
        require_once '/var/www/html/cse451-tranhuq-web/Todoist/routes/cas.php';

        //base uri -> it is important it end in /
        $uri = "https://api.todoist.com/rest/v1/tasks?project_id=";
        $uri = $uri . $id;


        //create a new client
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $uri,
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);

        try {
        $header = array("Authorization"=>"Bearer " . $_SESSION['token']);

        $response = $client->request('GET','',['headers'=>$header]);
        } catch (Exception $e) {
          print "There was an error getting the projects from todoist";
          header("content-type: text/plain",true);
          print_r($e);
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

        $tasks = array();

        foreach  ($jbody as &$task) {
            print($task);
        }

        return view('task', ['user' => $user], ['tasks'=>$tasks]);
    }
}
