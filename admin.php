<?php

require( "config.php" );
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
$loggedin = isset( $_SESSION['loggedin'] ) ? $_SESSION['loggedin'] : "";
//trigger_error(var_dump($_SESSION), E_USER_ERROR);
if ( $action != "login" && $action != "logout" && !$loggedin ) {
  login();
  exit;
}

switch ( $action ) {
  case 'login':
    login();
    break;
  case 'logout':
    logout();
    break;
  case 'newUpdate':
    newUpdate();
    break;
  case 'editUpdate':
    editUpdate();
    break;
  case 'deleteUpdate':
    deleteUpdate();
    break;
  default:
    adminDashboard();
}

function login() {

  $results = array();
  $results['pageTitle'] = "Login | Tarkov Dev Roadmap";

  if ( isset( $_POST['login'] ) ) {

    // User has posted the login form: attempt to log the user in
    if ( User::login($_POST['email'], $_POST['password']) ) 
	{
      header( "Location: admin.php" );
    } 
	else 
	{
      // Login failed: display an error message to the user
      $results['errorMessage'] = "Incorrect email or password. Try again.";
      require( "admin/loginForm.php" );
    }

  } else {
	if ( isset( $_GET['status'] ) ) {
		if ( $_GET['status'] == "logoutSuccess") $results['statusMessage'] = "Logged out succesfully.";
	}
    // User has not posted the login form yet: display the form
    require( "admin/loginForm.php" );
  }

}

function logout() {
  session_destroy();
  User::logout();
  header( "Location: admin.php?status=logoutSuccess" );
}

function newUpdate() {

  $results = array();
  $results['pageTitle'] = "New Update | Tarkov Dev Roadmap";
  $results['formAction'] = "newUpdate";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the update edit form: save the new update
    $update = new Update;
    $update->storeFormValues( $_POST );
    $update->insert();
	if ( isset( $_FILES['updateImages'] ) ) $update->storeUploadedImage( $_FILES['updateImages'] );
    header( "Location: admin.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the update list
    header( "Location: admin.php" );
  } else {

    // User has not posted the update edit form yet: display the form
    $results['updates'] = new Update;
    require( "admin/editUpdate.php" );
  }

}

function editUpdate() {

  $results = array();
  $results['pageTitle'] = "Edit Update | Tarkov Dev Roadmap";
  $results['formAction'] = "editUpdate";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the update edit form: save the update changes

    if ( !$update = Update::getById( (int)$_POST['id_update'] ) ) {
      header( "Location: admin.php?error=updateNotFound" );
      return;
    }

    $update->storeFormValues( $_POST );
	if ( isset($_POST['deleteImage']) && $_POST['deleteImage'] == "yes" ) $update->deleteImages();
    $update->update();
	if ( isset( $_FILES['updateImages'] ) ) $update->storeUploadedImage( $_FILES['updateImages'] );
    header( "Location: admin.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the update list
    header( "Location: admin.php" );
  } else {

    // User has not posted the u[date edit form yet: display the form
    $results['updates'] = Update::getById( (int)$_GET['id_update'] );
    require( "admin/editUpdate.php" );
  }

}

function deleteUpdate() {

  if ( !$update = Update::getById( (int)$_GET['id_update'] ) ) {
    header( "Location: admin.php?error=updateNotFound" );
    return;
  }

  $update->deleteImages();
  $update->delete();
  
  header( "Location: admin.php?status=updateDeleted" );
}


function adminDashboard() {
  $results = array();
  $data = Update::getList();
  $results['updates'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "Dashboard | Tarkov Dev Roadmap";

  if ( isset( $_GET['error'] ) ) {
    if ( $_GET['error'] == "updateNotFound" ) $results['errorMessage'] = "Error: Update not found!";
  }

  if ( isset( $_GET['status'] ) ) {
    if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes were saved.";
    if ( $_GET['status'] == "updateDeleted" ) $results['statusMessage'] = "Update deleted.";
	if ( $_GET['status'] == "logoutSuccess") $results['statusMessage'] = "Logged out succesfully.";
  }

  require( "admin/adminDashboard.php" );
}

?>
