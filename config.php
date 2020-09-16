<?php
ini_set( "display_errors", true );
date_default_timezone_set( "America/Sao_Paulo" );  // http://www.php.net/manual/en/timezones.php
define( "DB_DSN", "mysql:host=localhost;dbname=tarkov_dev_roadmap" );
define( "DB_USERNAME", "root" );
define( "DB_PASSWORD", "" );
define( "CLASS_PATH", "classes" );
define( "TEMPLATE_PATH", "templates" );
//require( CLASS_PATH . "/User.php" );
//require( "dist/standAloneFuncs.php" );
setlocale(LC_ALL, 'portuguese-brazilian', 'ptb', 'pt_BR');

function handleException( Throwable $t ) {
echo "Oops! Tivemos um problema. Tente Novamente mais tarde." . $t;
error_log( $t->getMessage() );
}

set_exception_handler( 'handleException' );

// Initialize the session
session_start();
?>
