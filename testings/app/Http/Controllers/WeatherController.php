<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    public function hello()
    {
        return response()->json([
        "status" => "OK",
        "message" => "Hello World!"
        ], 200);

    }
}
