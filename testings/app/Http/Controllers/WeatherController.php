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
        header("content-type: application/json");
        header("Access-Control-Allow-Headers: Content-Type");

        $r['message'] = "Hello World!";
        print json_encode($r);
        exit;


    }
}
