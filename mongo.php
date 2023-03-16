<?php

$name=$_POST['name'];
$email=$_POST['email'];

$uri = 'mongodb+srv://Gokul:TN33BB3621@cluster0.x8urb.mongodb.net/';
$manager = new MongoDB\Driver\Manager($uri);

$database = "guvi";
$collection = "users";

$bulk = new MongoDB\Driver\BulkWrite;

$document = [
    'email' => $email,
    'name' => $name,
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