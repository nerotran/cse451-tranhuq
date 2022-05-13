<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RandomController extends Controller
{
    public function getRandom()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET");
        header("content-type: application/json");
        header("Access-Control-Allow-Headers: Content-Type");

        function sendJson($status,$result) {
              $returnData = array();
              foreach ($result as $k=>$v) {
                $returnData[$k] = $v;
              }

            print json_encode($returnData);
            exit;
        }

        $numbers =  array();
        for ($x = 0; $x <= rand(0,9);$x++) {
            $numbers[] = rand();
        }

        $r["numbers"] = $numbers;
        sendJson("OK", $numbers);
    }

}
