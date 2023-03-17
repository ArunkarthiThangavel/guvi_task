<?php
// $servername = "localhost";
// $username ="root";
// $password="";
// $dbname="guvi";
// $connect=mysqli_connect($servername,$username,$password,$dbname);

// $name=$_POST['name'];
// $email=$_POST['email'];
// $password=$_POST['password'];
// $phone=$_POST['phone'];

// if(mysqli_connect_errno())
// {
//     echo "falied to connect";
// }

// if( isset($email)  && isset($password) )
// {
//     $sql = "INSERT INTO register(email,password) VALUES('".addslashes($email)."','".addslashes($password)."')";
//     $connect->query($sql);
// }



// $uri = 'mongodb+srv://arunkarthit:12345@guvicluster.hv8he1i.mongodb.net/';
// $manager = new MongoDB\Driver\Manager($uri);

// $database = "guvi";
// $collection = "register";

// $bulk = new MongoDB\Driver\BulkWrite;

// $document = [
//     'name' => $name,
//     'email' => $email,
//     'phone'=>$phone,
// ];

// $bulk = new MongoDB\Driver\BulkWrite;

// // Add insert operation to bulk write object
// $bulk->insert($document);

// // Create MongoDB write concern object
// $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

// // Execute bulk write operation
// $result = $manager->executeBulkWrite("$database.$collection", $bulk, $writeConcern);

// // Print result
// printf("Inserted %d document(s)\n", $result->getInsertedCount());

?>


<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

class DbConnect {
    private $server = 'localhost';
    private $databasename = 'guvi';
    private $user = 'root';
    private $password = "";

    public function connect() {
        try {
            $conn = new PDO('mysql:host=' .$this->server .';dbname=' . $this->databasename, $this->user, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
            echo "Connection success";
        } catch (\Exception $e) {
            echo "Database Error: " . $e->getMessage();
        }
    }
}

$email = $_POST['email'];
$password = $_POST['password'];
$name=$_POST['name'];
$phone=$_POST['phone'];
$dob=$_POST['dob'];
$age=$_POST['age'];

$uri = 'mongodb+srv://arunkarthit:12345@guvicluster.hv8he1i.mongodb.net/';
$manager = new MongoDB\Driver\Manager($uri);

$database = "guvi";
$collection = "register";

$bulk = new MongoDB\Driver\BulkWrite;

$document = [
    'email' => $email,
    'phone'=>$phone,
    'name'=>$name,
    'dob'=>$dob,
    'age'=>$age,
];

$bulk = new MongoDB\Driver\BulkWrite;

$_id = $bulk->insert($document);

$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

$result = $manager->executeBulkWrite("$database.$collection", $bulk, $writeConcern);

$mongoId = (string)$_id;
$objDb = new DbConnect;
$conn = $objDb->connect();
$sql = "INSERT INTO register VALUES (:email, :password,:mongoId)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':mongoId',$mongoId);

if ($stmt->execute()) {
    $data['success'] = true;
    $data['errors'] = false;
    $data['message'] = 'Success!';
} else {
    $errors['login'] = "SignUp Failed";
    $data['success'] = false;
}
echo json_encode($data);
?>

