<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    public function hello()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET,POST,PUSH,OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
        header("content-type: application/json");
        

        function sendJson($status,$result) {
              $returnData = array();
              $returnData['status'] = $status;
              foreach ($result as $k=>$v) {
                $returnData[$k] = $v;
              }

            print json_encode($returnData);
            exit;
        }

        $r['message'] = "Hello World!";

        sendJson("OK",$r);

    }
}
