<?php
$servername = "localhost";
$username ="root";
$password="";
$dbname="guvi";
$connect=mysqli_connect($servername,$username,$password,$dbname);

$name=$_POST['name'];
$email=$_POST['email'];
$password=$_POST['password'];
$phone=$_POST['phone'];

if(mysqli_connect_errno())
{
    echo "falied to connect";
}

if( isset($email)  && isset($password) )
{
    $sql = "INSERT INTO register(email,password) VALUES('".addslashes($email)."','".addslashes($password)."')";
    $connect->query($sql);
}



$uri = 'mongodb+srv://arunkarthit:12345@guvicluster.hv8he1i.mongodb.net/';
$manager = new MongoDB\Driver\Manager($uri);

$database = "guvi";
$collection = "register";

$bulk = new MongoDB\Driver\BulkWrite;

$document = [
    'name' => $name,
    'email' => $email,
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




