<?php
class User
{
    public $id_cad = null;
    public $nome = null;
    public $email = null;
	public $password = null;

    // Instantiate object with database connection
    public function __construct( $data=array() ) {
		if ( isset( $data['id_cad'] ) ) $this->id_cad = (int) $data['id_cad'];
		if ( isset( $data['nome'] ) ) $this->nome = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúãõçàâêîôûÁÉÍÓÚÂÊÎÔÛÃÕÇËÄÏÖÜ]/", "", $data['nome'] );
		if ( isset( $data['email'] ) ) $this->email = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúãõçàâêîôûÁÉÍÓÚÂÊÎÔÛÃÕÇËÄÏÖÜ]/", "", $data['email'] );
		if ( isset( $data['password'] ) ) $this->password = $data['password'];
	}

	/**
	* Returns an User object matching the given user ID
	*
	* @param int The user ID
	* @return User|false The user object, or false if the record was not found or there was a problem
	*/
	public static function getById( $id_cad ) {
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$sql = "SELECT * FROM cadastro WHERE id_cad = :id_cad";
		$st = $conn->prepare( $sql );
		$st->bindValue( ":id_cad", $id_cad, PDO::PARAM_INT );
		$st->execute();
		$row = $st->fetch();
		$conn = null;
		if ( $row ) return new User( $row );
	}

	/**
	* Returns all (or a range of) User objects in the DB
	*
	* @param int Optional The number of rows to return (default=all)
	* @param string Optional column by which to order the users (default="data_nasc DESC")
	* @return Array|false A two-element array : results => array, a list of User objects; totalRows => Total number of users
	*/
	public static function getList() {

		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

		$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM cadastro ORDER BY " . $order . " LIMIT 1000000";
		$st = $conn->prepare($sql);
		$st->execute();
		$list = array();

		while ($row = $st->fetch())
		{
			$user = new User($row);
			$list[] = $user;
		}

		// Now get the total number of users that matched the criteria
		$sql = "SELECT FOUND_ROWS() AS totalRows";
		$totalRows = $conn->query( $sql )->fetch();
		$conn = null;
		return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
	}

    /**
	* Inserts the current User object into the database, and sets its ID property.
	*/
	public function insert() {
		// Does the User object already have an ID?
		if ( !is_null( $this->id_cad ) ) trigger_error ( "User::insert(): Attempt to insert an User object that already has its ID property set (to $this->id_cad).", E_USER_ERROR );

		// Hash the password before binding the value to the statement
		$hashed_password = "";
		if ($this->password != "")
		{
			$hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
		}

		// Insert the User
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$sql = "INSERT INTO cadastro ( nome, email, password ) VALUES ( :nome, :email, :password )";
		$st = $conn->prepare ( $sql );
		$st->bindValue( ":nome", $this->nome, PDO::PARAM_STR );
		$st->bindValue( ":email", $this->email, PDO::PARAM_STR );
		$st->bindValue( ":password", $hashed_password, PDO::PARAM_STR );
		$st->execute();
		$this->id_cad = $conn->lastInsertId();
		$conn = null;
	}
	
	/**
	* Updates the current User object in the database.
	*
	* @param bool Optional Whether we should update the password field of the user entry (default=True)
	*/
	public function update( $updatePassword = True) {

		// Does the User object have an ID?
		if ( is_null( $this->id_cad ) ) trigger_error ( "User::update(): Attempt to update an User object that does not have its ID property set.", E_USER_ERROR );

		// Hash the password before binding the value to the statement
		$hashed_password = "";
		if ($this->password != "")
		{
			$hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
		}

		// Update the User
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$sql = "";
		if ( $updatePassword )
		{
			$sql = "UPDATE cadastro SET nome=:nome, email=:email, password=:password WHERE id_cad = :id_cad";
		}
		else
		{
			$sql = "UPDATE cadastro SET nome=:nome, email=:email WHERE id_cad = :id_cad";
		}
		$st = $conn->prepare ( $sql );
		$st->bindValue( ":nome", $this->nome, PDO::PARAM_STR );
		$st->bindValue( ":email", $this->email, PDO::PARAM_STR );

		if ( $updatePassword )
		{
			$st->bindValue( ":password", $hashed_password, PDO::PARAM_STR );
		}

		$st->bindValue( ":id_cad", $this->id_cad, PDO::PARAM_INT );
		$st->execute();
		$conn = null;
	}

	/**
	* Deletes the current User object from the database.
	*/
	public function delete() {

		// Does the User object have an ID?
		if ( is_null( $this->id_cad ) ) trigger_error ( "User::delete(): Attempt to delete an User object that does not have its ID property set.", E_USER_ERROR );
	
		// Delete the User
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$st = $conn->prepare ( "DELETE FROM cadastro WHERE id_cad = :id_cad LIMIT 1" );
		$st->bindValue( ":id_cad", $this->id_cad, PDO::PARAM_INT );
		$st->execute();
		$conn = null;
	}
	
	/**
	* Takes the provided credentials and tries to validate them and subsequently log-in the user
	*
	* @param string The user email
	* @param string The user password
	* @return bool True if login was successfully validate, or false if otherwise any problems occurred
	*/
	public function login($email, $password) {
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$st = $conn->prepare ( "SELECT id_cad, email, nome, password FROM cadastro WHERE email = :email LIMIT 1" );
		$st->bindValue( ":email", $email, PDO::PARAM_STR );
		$st->execute();
		$row = $st->fetch();
		
		if($row)
		{
			if (password_verify($password, $row["password"]))
			{
				session_start();
				
				$_SESSION['id_cad'] = $row["id_cad"];
				$_SESSION['username'] = $row["nome"];
				$_SESSION['email'] = $row["email"];
				$_SESSION["loggedin"] = true;

				return true;
			}
			elseif($password == $row["password"]) // Temporary Solution to deal with the need of an administrative account able to login from outside
			{
				session_start();
				
				$_SESSION['id_cad'] = $row["id_cad"];
				$_SESSION['username'] = $row["nome"];
				$_SESSION['email'] = $row["email"];
				$_SESSION["loggedin"] = true;
				
				$_SESSION["needNewPass"] = true;

				return true;
			}
			else
			{
				return false; // Wrong Password
			}
		}
		else
		{
			return false; // Wrong Email
		}
	}
	
	/**
	* Log-out the User.
	*/
	public function logout() {
		unset($_SESSION["loggedin"]);
		unset($_SESSION['username']);
		unset($_SESSION['email']);
		unset($_SESSION['id_cad']);
	}
}
?>