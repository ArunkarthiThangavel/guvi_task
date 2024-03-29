<?php 

$servername = "localhost";
$username ="root";
$password="";
$database="guvi";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

ini_set('session.save_handler', 'redis');
ini_set('session.save_path', 'tcp://127.0.0.1:6379');


$email = $_POST["email"];
$password = $_POST["password"];

$result = mysqli_query($conn, "SELECT * FROM register WHERE email = '$email'");

if (mysqli_num_rows($result) == 0) {
    $response = array(
        "status" => "error",
        "message" => "User not found"
    );
    echo json_encode($response);
} else {
    $row = mysqli_fetch_assoc($result);
    
    if($password==$row['password']){
        $session_id = uniqid();
        $redis->set("session:$session_id", $email);
        $redis->expire("session:$session_id", 10*60);
        
        $response = array(
            "status" => "success",
            "message" => "Login successful",
            "session_id" => $session_id
        );
        echo json_encode($response);
    } else {

        $response = array(
            "status" => "error",
            "message" => "Incorrect password"
        );
        echo json_encode($response);
    }
}

?>