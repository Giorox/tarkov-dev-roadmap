<?php
header('Content-Type: application/json');
require_once( "../../config.php" );

$id = 0;
$newPassValue = "";

if( isset($_POST['id']) )
{
	$id = (int)$_POST['id'];
}

if( isset($_POST['newPassValue']) )
{
	$newPassValue = $_POST['newPassValue'];
}

// Hash the password
$hashed_password = password_hash($newPassValue, PASSWORD_DEFAULT);

// Pull information for the requested user
// Open a new PDO connection
$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

// Build the SQL statement to be executed
$sql = "UPDATE cadastro SET password=:password WHERE id_cad = " . $id;

// Prepare, Bind and Execute
$stmt = $conn->prepare($sql);
$stmt->bindValue( ":password", $hashed_password, PDO::PARAM_STR );
$stmt->execute();

// Kill the connection
$conn = null;

echo 1;

?>