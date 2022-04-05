<?php
/*
 *Name: Nero Tran Huu
 *Course: CSE 551
 *Assignment: rest3-billboard
 *Date: 3/28/2022
 *File: rest.php
 **/


session_start();
require "vendor/autoload.php";
use GuzzleHttp\Client;

//create db connection
require_once ".db.php";

$conn = new mysqli($servername, $master,$mpass,$db);
if ($conn->connect_error) {
  die("Error 2 connecting ". $conn->connect_error);
}


//produce secret token
function getToken($nonce) {
  global $MYSECRETTOKEN;
  return hash_hmac('ripemd160','nero'.$nonce,$MYSECRETTOKEN);
}

$nonce = time();

//update the thumbs state
function updateThumbs($song,$thumb) {
  global $conn;
  error_log("thumbs up $song $thumb");
  //setup thumbup on song
  if ($thumb != 1 && $thumb != 2) {
    error_log("Invalid thumb $thumb");
    sendJson(500,"Invalid Request",[]);
  }
  if ($thumb == 1) {
    $thumb = "likes";
  }

  if ($thumb == 2) {
    $thumb = "dislikes";
  }

  $sql = "update Billboard set $thumb=$thumb+1 where id=$song";
  if (!$stmt = $conn->prepare($sql)) {
    error_log("Error in sql " . $stmt->error);
    return "Failed, bad sql";
  }

  if (!$stmt->execute()) {
    error_log("Error on execute" . $conn->error);
    sendJson(500,"oops",[]);
  }
  error_log("good thumbs $sql $song $thumb");
  return array();
}

//table of songs
function getSongs($rank,$thumbsFilter,$offset) {
  global $conn;

  /*db fields
  id int(6) unsigned auto_increment primary key,
  `date` varchar(10),
  `rank` int,
  `song` varchar(100),
  `artist` text,
  `last-week` int,
  `peak-rank` int,
  `weeks-on-board` int,
  `thumbs int`)";
   */
  $thumbsQ = "";
  if ($thumbsFilter != "") {
    if ($thumbsFilter == "u") {
      $thumbsQ = "`thumbs`= 1";
    } elseif ($thumbsFilter == "d") {
      $thumbsQ = "`thumbs`= 2";
    }
  } else {
    $thumbsQ = "1=1";
  }
  $sql = "select * from `Billboard` where $thumbsQ";
    
  $rankQ=100;
  if ($rank != "all") {
    $rankQ = $rank;
    $sql = $sql . " and `rank`<=$rankQ";
  }

  if ($offset != "") {
    $offset = "0";
  }

  $sql = $sql . " limit 100 offset $offset";
  
  if (!$stmt = $conn->prepare($sql)) {
    error_log("Error in sql " . $stmt->error);
    return "Failed, bad sql";
  }

  if (!$stmt->execute()) {
    error_log("Error on execute" . $conn->error);
    sendJson(500,"oops",[]);

  }

  //iterate over each row
  $results=array();
  if (!$result = $stmt->get_result()) {
    error_log("Error on get result" . $conn->error);
    sendJson(500,"oops",[]);
  }

  while ($row = $result->fetch_array(MYSQLI_ASSOC)){
    $results[] = $row;
  }
  return $results;
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,POST,PUSH,OPTIONS");
header("content-type: application/json");
header("Access-Control-Allow-Headers: Content-Type");

function sendJson($status,$msg,$result) {
  $returnData = array();
  $returnData['status'] = $status;
  $returnData['msg'] = $msg;
  foreach ($result as $k=>$v) {
    $returnData[$k] = $v;
  }

  print json_encode($returnData);
  exit;
}

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
if (sizeof($parts) <3 || $parts[0] != "api"  || $parts[1] != "v1") {
  sendJson("FAIL","Bad Request not /api/vi",[]);
}
array_shift($parts);
array_shift($parts);

$method = strtolower($_SERVER['REQUEST_METHOD']);

if ($method == "options") {
  sendJson("OK","",[]);
}

//return songs with offset
if ($method=="get" &&  sizeof($parts) == 2 && $parts[0] == "songs" && is_numeric($parts[1])) {
  $retData = getSongs("all","",intval($parts[1]));
  $r['status'] = "OK";
  $r['songs'] = $retData;
  sendJson("OK","",$r);
}
//return songs with offset and with rank filter
else if ($method=="get" &&  sizeof($parts) == 3 && $parts[0] == "songs" && is_numeric($parts[1]) && is_numeric($parts[2])) {
  $retData = getSongs(intval($parts[2]),"",intval($parts[1]));
  $r['status'] = "OK";
  $r['songs'] = $retData;
  sendJson("OK","",$r);
}


//see if thumbs update
else if ($method=="post" &&  sizeof($parts) == 1 && $parts[0]== "songs") {
  //get and parse body
  $jsonBody = array();
  $errormsg = "none";
  try {
    # Get JSON as a string
    $json_str = file_get_contents('php://input');

    # Get as an object
    $jsonBody = json_decode($json_str,true);
  } catch (Exception $e) {
    $errormsg = $e->getMessage();
    sendJson("FAIL","bad request no body",[]);
  }

  //check data input
  if (!isset($jsonBody['songPK'])) {

    error_log("thumbs bad request songpk");
    sendJson("FAIL","no songPK",[]);
  }

  if (!isset($jsonBody['state'])) {
    error_log("thumbs bad request thumb");
    sendJson("FAIL","no state",[]);
  }

  if (!isset($jsonBody['token']) || !isset($jsonBody['nonce']) || getToken($jsonBody['nonce']) != $jsonBody['token']) {
    sendJson(403,"Token Failed",[]);
    exit;
  }
  

  $result = updateThumbs($jsonBody['songPK'],$jsonBody['state']);

  $r['status'] = "OK";
  sendJson("OK","",[]);
}

//thumbs API
else if ($method=="get" &&  sizeof($parts) > 1 && $parts[0] == "thumbs") {
  $retData = array();
  $temp = getSongs("all","","");
  for ($i=1;$i<sizeof($parts);$i++) {
    $retData[$parts[$i]] = array();
    $retData[$parts[$i]]["id"] = $parts[$i];
    $retData[$parts[$i]]["likes"] = $temp[$parts[$i]-1]["likes"];
    $retData[$parts[$i]]["dislikes"] = $temp[$parts[$i]-1]["dislikes"];
  }
  $r['status'] = "OK";
  $r['thumbs'] = $retData;
  sendJson("OK","",$r);
}

//overthumbs API
else if ($method=="get" &&  sizeof($parts) > 1 && $parts[0] == "overthumbs") {
  $url = 'https://campbest.451.csi.miamioh.edu/rest.php/api/v1/thumbs';
  for ($i=1;$i<sizeof($parts);$i++) {
    $url = $url . "/$parts[$i]";
  }

  $client = new Client([
      // Base URI is used with relative requests
      'base_uri' => $url,
      // You can set any number of default request options.
      'timeout'  => 2.0,
  ]);

  $response = $client->request('GET','');

  $body = json_decode($response->getBody(),true);
  $retData = $body["thumbs"];

  $r['status'] = "OK";
  $r['thumbs'] = $retData;
  sendJson("OK","",$r);

}

header($_SERVER['SERVER_PROTOCOL'] . ' 404 Invalid URL' , true, 400);
?>
