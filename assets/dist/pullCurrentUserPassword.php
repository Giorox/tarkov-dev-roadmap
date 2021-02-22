<?php
header('Content-Type: application/json');
require_once( "../../config.php" );

$id = 0;
$oldPassValue = "";

if( isset($_POST['id']) )
{
	$id = (int)$_POST['id'];
}

if( isset($_POST['oldPassValue']) )
{
	$oldPassValue = $_POST['oldPassValue'];
}

// Pull information for the requested user
// Open a new PDO connection
$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

// Build the SQL statement to be executed
$sql = "SELECT * FROM cadastro WHERE `id_cad` = " . $id;

// Prepare and Execute
$stmt = $conn->prepare($sql);
$stmt->execute();

// Pull result
$row = $stmt->fetch();

// Kill the connection
$conn = null;

// Pull the Update Object itself
if( ($row["password"] == $oldPassValue) or (password_verify($oldPassValue, $row["password"])) )
{
	echo true;
}
else
{
	echo false;
}

?>