<?php
header('Content-Type: application/json');
require_once( "../../config.php" );

$imagePath = "";
$updateID = 0;

$proceed = true;

if( isset($_POST['imagePath']) )
{
	$imagePath = $_POST['imagePath'];
}
else
{
	$proceed = false;
}

if( isset($_POST['updateID']) )
{
	$updateID = (int)$_POST['updateID'];
}
else
{
	$proceed = false;
}

if ( $proceed == true)
{
	$pathToUnlink = "../../" . $imagePath;
	
	// Delete the requested image from this update
	if ( !unlink( $pathToUnlink ) ) return 0;
	
	// Delete the database reference to this image
	$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
	$st = $conn->prepare ( "DELETE FROM updateImages WHERE filename = :filename AND id_ownerUpdate = :id_ownerUpdate LIMIT 1" );
	$st->bindValue( ":filename", $imagePath, PDO::PARAM_STR );
	$st->bindValue( ":id_ownerUpdate", $updateID, PDO::PARAM_INT );
	$st->execute();
	$conn = null;
	
	echo 1;
}
else
{
	echo 0;
}

?>