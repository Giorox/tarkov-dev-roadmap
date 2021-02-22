<?php
header('Content-Type: application/json');
require_once( "../../config.php" );

$id = 0;
if( isset($_POST['id']) )
{
	$id = (int)$_POST['id'];
}

// Array that will be json encoded at the end of the file
$jsonArray = array();

// Pull information for the desired event
// Open a new PDO connection
$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

// Build the SQL statement to be executed
$sql = "SELECT * FROM updates WHERE `id_update` = " . $id;

// Prepare and Execute
$stmt = $conn->prepare($sql);
$stmt->execute();

// Pull result
$row = $stmt->fetch();

// Kill the connection
$conn = null;

// Pull the Update Object itself
$updateObj = Update::getById( (int)$row["id_update"] );

// Pull ALL image paths
$arrayOfImagePaths = $updateObj->getAllImages();

// Return the results
if ( $row )
{
	$jsonArray["id_update"] = $row["id_update"];
	$jsonArray["updateName"] = $row["updateName"];
	$jsonArray["estimatedDate"] = $row["estimatedDate"];
	$jsonArray["extraInformation"] = $row["extraInformation"];
	$jsonArray["images"] = $arrayOfImagePaths;
}
else
{
	$jsonArray["id_update"] = "";
	$jsonArray["updateName"] = "";
	$jsonArray["estimatedDate"] = "";
	$jsonArray["extraInformation"] = "";
	$jsonArray["images"] = "";
}


echo json_encode($jsonArray);

?>