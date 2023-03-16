<?php
$servername = "localhost";
$username ="root";
$password="";
$dbname="guvi";
$connect=mysqli_connect($servername,$username,$password,$dbname);

$name=$_POST['name'];
$email=$_POST['email'];
$password=$_POST['name'];
$phone=$_POST['phone'];

if(mysqli_connect_errno())
{
    echo "falied to connect";
}

if(isset($name) && isset($email)  && isset($password)  && isset($phone))
{
    $sql = "INSERT INTO register(name,password,email,phone) VALUES('".addslashes($name)."','".addslashes($password)."','".addslashes($email)."','".addslashes($phone)."')";
    $connect->query($sql);
}



$uri = 'mongodb+srv://arunkarthit:12345@guvicluster.hv8he1i.mongodb.net/';
$manager = new MongoDB\Driver\Manager($uri);

$database = "guvi";
$collection = "guvi";

$bulk = new MongoDB\Driver\BulkWrite;

$document = [
    'name' => $name,
    'email' => $email,
    'password'=>$password,
    'phone'=>$phone,
];

$bulk = new MongoDB\Driver\BulkWrite;

// Add insert operation to bulk write object
$bulk->insert($document);

// Create MongoDB write concern object
$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

// Execute bulk write operation
$result = $manager->executeBulkWrite("$database.$collection", $bulk, $writeConcern);

// Print result
printf("Inserted %d document(s)\n", $result->getInsertedCount());

?>




