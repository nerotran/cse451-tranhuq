<?php
/*
 *Name: Nero Tran Huu
 *Course: CSE 551
 *Assignment: Exam2
 *Date: 4/6/2022
 *File: rest.php
 **/

session_start();

//helper function to get and sanitize REQUEST variables
function g($name) {
  if (isset($_REQUEST[$name]))
    return htmlspecialchars($_REQUEST[$name]);
  else
    return "";
}

require_once(".db.php");
$conn = new mysqli($servername,$master,$mpass,$db);

if ($conn->connect_error) {
    die("Error 2 connecting". $conn->connect_error);
}

function get() {
    global $conn;
    $sql = "select * from `exam2`";
    
    $result = $conn->query($sql);
    
    if ($result  == "")
    {
        print "Error";  print $conn->error; exit;
    }


    $retdata = array();
    while ($row = $result->fetch_assoc()) {
      $temp = array();
      $temp["rnd"] = $row["rnd"];
      $retdata[] = $temp;
    }

    return $retdata;
}

//helper function to send resposne
function sendJson($status,$msg,$data) {
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET,POST,PUSH,OPTIONS");
  header("content-type: application/json");
  header("Access-Control-Allow-Headers: Content-Type");

  $retdata = array();
  $retdata["status"] = $status;
  $retdata["msg"] = $msg;
  foreach ($data as $key => $value) {
    $retdata[$key] = $value;
  }

  print json_encode($retdata);
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

array_shift($parts);

if ($_SERVER['REQUEST_METHOD'] == "GET" && $parts[0] == "live") {
  $retdata = array();
  $retdata["rnd"] = get();
  sendJson("OK","",$retdata);
}

header($_SERVER['SERVER_PROTOCOL'] . ' 404 Invalid URL' , true, 400);
?>
