<?php 

$servername = "localhost";
$username ="root";
$password="";
$database="guvi";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$email = $_POST["email"];
$email = 'a@gmail.com';
print $email;
$password = $_POST["password"];
$result = mysqli_query($conn, "SELECT * FROM register WHERE email = '$email'");
print $result;
if (mysqli_num_rows($result) == 0) {
    $response = array(
        "status" => "error",
        "message" => "User not found"
    );
    echo json_encode($response);
} else {
    $row = mysqli_fetch_assoc($result);
    
    if($password==$row['password']){
        $payload = array(
            "email" => $row['email'],
            "expires_at" => time() + 3600 // Expires in 1 hour
        );
        
       $access_token = base64_encode(json_encode($payload));
        $response = array(
            "status" => "success",
            "message" => "Login successful",
            "access_token" => $access_token
        );
        echo json_encode($response);
    } else {
        print_r('aruj');
        $response = array(
            "status" => "error",
            "message" => "Incorrect password"
        );
        echo json_encode($response);
    }
}

?>