<?php 

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);


if ($_POST['action'] === 'logout') {
    $redis->del("session:$redisId");
    $response = array(
        "status" => "success",
        "message" => "Logout successful",
    );
    echo json_encode($response);
}
if ($_POST['action'] === 'valid-session'){
  $redisId = $_POST["redisId"];
  if ($redis->get("session:$redisId")) {
    $sessionData = $redis->get("session:$redisId");
    $response = array(
        "status" => "success",
        "message" => "Session is valid",
    );
    echo json_encode($response);
  }
  else
  {
    $response = array(
        "status" => "error",
        "message" => "Session is invalid",
    );
    echo json_encode($response);
  }
}

if ($_POST['action'] === 'get-data'){
  $redisId = $_POST["redisId"];
  $sessionData = $redis->get("session:$redisId");

  $email = $sessionData;
  

  $manager = new MongoDB\Driver\Manager("mongodb+srv://arunkarthit:12345@guvicluster.hv8he1i.mongodb.net/?retryWrites=true&w=majority");
  $database = "guvi";
  $collection = "register";

  $filter = ['email' => $email];

  $options = [];

  $query = new MongoDB\Driver\Query($filter, $options);

  $cursor = $manager->executeQuery("$database.$collection", $query);

  foreach ($cursor as $document) {
    $data[] = $document;
  }

  if (!empty($data)) {
    $response = ['status' => 'success', 'data' => $data];
  }else{
    $response = ['status' => 'error', 'message' => 'No data found.'];
  }
  echo json_encode($response);
}

if (isset($_POST['action']) && $_POST['action'] === 'update-data'){
  $email = $_POST["email"];
  $data = $_POST["data"];

  $dob = $data['dob'];
  $contact = $data['contact'];
  $age = $data['age'];
  $manager = new MongoDB\Driver\Manager("mongodb+srv://arunkarthit:<password>@guvicluster.hv8he1i.mongodb.net/?retryWrites=true&w=majority");
  $database = "guvi";
  $collection = "register";
  $filter = ['email' => $email];
  $update = ['$set' => ['age' => $age, 'contact' => $contact , 'dob' => $dob]];

  // specify options
  $options = ['multi' => false, 'upsert' => false];

  // specify the database and collection to update
  $bulk = new MongoDB\Driver\BulkWrite;
  $bulk->update($filter, $update, $options);
  $result = $manager->executeBulkWrite("$database.$collection", $bulk);

  // check if the update was successful
  if ($result->getModifiedCount() > 0) {
    $response = ['status' => 'success', 'message' => 'updated successfully'];
  } else {
    $response = ['status' => 'error', 'message' => 'update failed'];
  }

  echo json_encode($response);
}

?>