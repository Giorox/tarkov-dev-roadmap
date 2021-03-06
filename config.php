<?php
ini_set( "display_errors", true );
date_default_timezone_set( "America/Sao_Paulo" );  // http://www.php.net/manual/en/timezones.php
define( "DB_DSN", "mysql:host=localhost;dbname=tarkov_dev_roadmap" );
define( "DB_USERNAME", "root" );
define( "DB_PASSWORD", "" );
define( "CLASS_PATH", "classes" );
define( "TEMPLATE_PATH", "templates" );
define( "IMAGE_PATH", "images" );
require( CLASS_PATH . "/User.php" );
require( CLASS_PATH . "/Update.php" );
setlocale(LC_ALL, 'portuguese-brazilian', 'ptb', 'pt_BR');

function handleException( Throwable $t ) {
echo "Oops! There was a problem. Try again later." . $t;
error_log( $t->getMessage() );
}

set_exception_handler( 'handleException' );

// Initialize the session
session_start();
?>
