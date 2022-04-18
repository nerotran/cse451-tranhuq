<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    public function getTemp()
    {
        require '/var/www/html/cse451-tranhuq-web/Buildings/vendor/autoload.php'; 
        $APIKEY = env('OPENWEATHER_API_KEY','');
        if ($APIKEY == "") {
              die ("API KEY NOT DEFINED");
        }

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET,POST,PUSH,OPTIONS");
        header("content-type: application/json");
        header("Access-Control-Allow-Headers: Content-Type");

        function sendJson($status,$result) {
              $returnData = array();
              $returnData['status'] = $status;
              foreach ($result as $k=>$v) {
                $returnData[$k] = $v;
              }

            print json_encode($returnData);
            exit;
        }


        //base uri -> it is important it end in /
        $uri = "https://api.openweathermap.org/data/2.5/weather?zip=45056,US&units=imperial&appid=";
        $uri = $uri . $APIKEY;

        //parse parts
        if (isset($_SERVER['PATH_INFO'])) {
          $parts = explode("/",$_SERVER['PATH_INFO']);
          //sanitize
          for ($i=0;$i<count($parts);$i++) {
            $parts[$i] = htmlspecialchars($parts[$i]);
          }
        } else {
          $parts = array();
        }

        array_shift($parts);  //get rid of first part of url which is bogus
        //get method type
        //

        //check api/v1 and shift off stack
        if (sizeof($parts) <2 || $parts[0] != "api") {
          sendJson("FAIL","Bad Request not /api",[]);
        }
        array_shift($parts);

        $method = strtolower($_SERVER['REQUEST_METHOD']);

        if ($method == "options") {
          sendJson("OK","",[]);
        }

        if ($method=="get" &&  sizeof($parts) == 1 && $parts[0] == "temp") {
            

            If (Cache::has(‘temp’)) {
                $temp = Cache::get(‘temp’);
                $r['status'] = "CACHE";
                $r['temp'] = $temp;
                sendJson("OK",$r);
            } else {

                //create a new client
                $client = new Client([
                    // Base URI is used with relative requests
                    'base_uri' => $uri,
                    // You can set any number of default request options.
                    'timeout'  => 2.0,
                ]);

                try {

                    $response = $client->request('GET','');
                } catch (Exception $e) {
                  header("content-type: text/plain",true);
                  print_r($e);
                  $a=print_r($e,true);
                  exit;
                }
                $body = (string) $response->getBody();
                $jbody = json_decode($body);
                if (!$jbody) {
                  error_log("no json");
                }

                $temp = $jbody["main"]["temp"];
                
                //store temp in the cache
                Cache::put(‘temp’,$temp,$seconds=15); //this will tell laravel to cache this object for 15 seconds.

                $r['status'] = "LIVE";
                $r['temp'] = $temp;
                sendJson("OK",$r);
            }
        }
    }
}
