<?php
header('Content-Type: application/json');
require_once( "../../config.php" );

// Array that will be json encoded at the end of the file
$jsonArray = array();

// Pull information for the desired event
// Open a new PDO connection
$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

// Build the SQL statement to be executed
$sql = "SELECT id_update, updateName, estimatedDate, extraInformation, isWipe FROM updates";

// Prepare and Execute
$stmt = $conn->prepare($sql);
$stmt->execute();

// Pull results and put each object into the array
$list = array();
while ($row = $stmt->fetch())
{
	$list[] = $row;
}

// Kill the connection
$conn = null;

$treatedEventArray = array();
foreach ($list as $event)
{
	$eventNode = array(
		"id" => $event["id_update"],
		"date" => $event["estimatedDate"],
		"content" => $event["updateName"],
		"wipe" => $event["isWipe"]
	);
	
	array_push($treatedEventArray, $eventNode);
}

// Add results to json array
$jsonArray["data"] = $treatedEventArray;

echo json_encode($jsonArray);

?>