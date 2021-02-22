<?php
header('Content-Type: application/json');
require_once( "../../config.php" );

$variableName = "";

if( isset($_POST['variableName']) )
{
	$variableName = $_POST['variableName'];
}

if( isset($_SESSION[$variableName]) )
{
	unset($_SESSION[$variableName]);
}

echo 1;

?>