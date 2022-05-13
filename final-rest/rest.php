
<?php
//create db connection
require_once ".db.php";

$conn = new mysqli($servername, $master,$mpass,$db);
if ($conn->connect_error) {
  die("Error 2 connecting ". $conn->connect_error);
}

//update the thumbs state
function delete() {
  global $conn;

  $sql = "truncate final";
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


function update($name) {
  global $conn;

  $sql = "update final set name=$name";
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

function get() {
  global $conn;
  $sql = "select * from `final`";
  
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
header("Access-Control-Allow-Methods: GET,POST,DELETE");
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

if ($method=="get" &&  sizeof($parts) == 1 && $parts[0] == "final") {
  $retData = get();
  $r['names'] = $retData;
  sendJson("OK","",$r);
}

else if ($method=="post" &&  sizeof($parts) == 1 && $parts[0]== "finals") {
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

  

  $result = update($jsonBody['name']);

  $r['status'] = "OK";
  sendJson("OK","",[]);
}

if ($method=="delete" &&  sizeof($parts) == 1 && $parts[0] == "final") {
  $retData = delete();
  sendJson("OK","",[]);
}


header($_SERVER['SERVER_PROTOCOL'] . ' 404 Invalid URL' , true, 400);
?>
