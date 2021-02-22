<?php

/**
 * Class to handle updates
 */

class Update
{
	// Properties
	
	/**
	* @var int The update ID from the database
	*/
	public $id_update = null;
	
	/**
	* @var string When the update is estimated to go live
	*/
	public $estimatedDate = null;
	
	/**
	* @var string The "name" of the update
	*/
	public $updateName = null;
	
	/**
	* @var string The HTML content of the update
	*/
	public $extraInformation = null;
	
	/**
	* @var bool Whether this is a WIPE or not
	*/
	public $isWipe = null;

	/**
	* Sets the object's properties using the values in the supplied array
	*
	* @param assoc The property values
	*/
	public function __construct( $data=array() ) 
	{
		if ( isset( $data['id_update'] ) ) $this->id_update = (int) $data['id_update'];
		if ( isset( $data['estimatedDate'] ) ) $this->estimatedDate = $data['estimatedDate'];
		if ( isset( $data['updateName'] ) ) $this->updateName = $data['updateName'];
		if ( isset( $data['extraInformation'] ) ) $this->extraInformation = $data['extraInformation'];
		if ( isset( $data['isWipe'] ) ) $this->isWipe = $data['isWipe'];
	} 


	/**
	* Sets the object's properties using the edit form post values in the supplied array
	*
	* @param assoc The form post values
	*/
	public function storeFormValues ( $params ) 
	{
		// Store all the parameters
		$this->__construct( $params );
	}


	/**
	* Stores any image uploaded from the edit form
	*
	* @param assoc The 'image' element from the $_FILES array containing the file upload data
	*/
	public function storeUploadedImage( $image )
	{
		
		if ( $image['error'][0] == UPLOAD_ERR_OK )
		{
			// Does the Update object have an ID?
			if ( is_null( $this->id_update ) ) trigger_error( "Update::storeUploadedImage(): Attempt to upload an image for an Update object that does not have its ID property set.", E_USER_ERROR );
 
			// Delete any previous image(s) for this user
			//$this->deleteImages();
 
			// Filter all the files
			$files = array_filter($image['name']);
			
			// Count how many files we have
			$total = count($image['name']);
			
			
			for($i = 0; $i < $total; $i++)
			{
				// Get the image filename extension
				$imageExtension = strtolower( strrchr( $image['name'][$i], '.' ) );
				
				// Get the image temporary filename
				$tempFilename = trim( $image['tmp_name'][$i] );
				
				// Make sure we have an actual file path
				if ($tempFilename != "")
				{
					//Setup our new file path
					$newFilePath = "images/updates/" . $image['name'][$i];
					
					if ( is_uploaded_file ( $tempFilename ) ) 
					{
						if ( !( move_uploaded_file( $tempFilename, $newFilePath ) ) ) trigger_error( "Update::storeUploadedImage(): Couldn't move uploaded file.", E_USER_ERROR );
						if ( !( chmod( $newFilePath, 0666 ) ) ) trigger_error( "Update::storeUploadedImage(): Couldn't set permissions on uploaded file.", E_USER_ERROR );
						
						// Insert the Image reference into it's table
						$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
						$sql = "INSERT INTO updateImages ( id_ownerUpdate, filename ) VALUES (  :id_ownerUpdate, :filename )";
						$st = $conn->prepare ( $sql );
						$st->bindValue( ":id_ownerUpdate", $this->id_update, PDO::PARAM_STR );
						$st->bindValue( ":filename", $newFilePath, PDO::PARAM_STR );
						$st->execute();
						$conn = null;
					}
				}
			}

			$this->update();
		}
	}


	/**
	* Deletes any images associated with the update
	*/
	public function deleteImages() 
	{
		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
	
		$sql = "SELECT * FROM updateImages WHERE id_ownerUpdate = :id_ownerUpdate LIMIT 1000000";
		$st = $conn->prepare($sql);
		$st->bindValue( ":id_ownerUpdate", $this->id_update, PDO::PARAM_INT );
		$st->execute();
		$list = array();
	
		while ($row = $st->fetch())
		{
			$list[] = $row;
		}

		$conn = null;

		// Delete all images for this update
		foreach ($list as $filename)
		{
			if ( !unlink( $filename["filename"] ) ) trigger_error( "Update::deleteImages(): Couldn't delete image file.", E_USER_ERROR );
		}
		
		// Delete all images related to this update
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$st = $conn->prepare ( "DELETE FROM updateImages WHERE id_ownerUpdate = :id_ownerUpdate" );
		$st->bindValue( ":id_ownerUpdate", $this->id_update, PDO::PARAM_INT );
		$st->execute();
		$conn = null;
	}


	/**
	* Returns if this update has any images
	*
	* @return bool True if the update has any images, or false if an image hasn't been uploaded
	*/
	public function has_image()
	{
		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
	
		$sql = "SELECT * FROM updateImages WHERE id_ownerUpdate = :id_ownerUpdate LIMIT 1000000";
		$st = $conn->prepare($sql);
		$st->bindValue( ":id_ownerUpdate", $this->id_update, PDO::PARAM_INT );
		$st->execute();
		$list = array();
	
		while ($row = $st->fetch())
		{
			$list[] = $row;
		}

		$conn = null;
		
		return ( count($list) > 0 ) ? true : false;
	}


	/**
	* Returns all images related to this update
	*
	* @return array Array of images related to this update
	*/
	public function getAllImages()
	{
		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
	
		$sql = "SELECT filename FROM updateImages WHERE id_ownerUpdate = :id_ownerUpdate LIMIT 1000000";
		$st = $conn->prepare($sql);
		$st->bindValue( ":id_ownerUpdate", $this->id_update, PDO::PARAM_INT );
		$st->execute();
		$list = array();
	
		while ($row = $st->fetch())
		{
			$list[] = $row["filename"];
		}

		$conn = null;
		
		return $list;
	}
	
	
	/**
	* Returns an Update object matching the given update ID
	*
	* @param int The update ID
	* @return Update|false The update object, or false if the record was not found or there was a problem
	*/
	public static function getById( $id_update ) {
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$sql = "SELECT * FROM updates WHERE id_update = :id_update";
		$st = $conn->prepare( $sql );
		$st->bindValue( ":id_update", $id_update, PDO::PARAM_INT );
		$st->execute();
		$row = $st->fetch();
		$conn = null;
		if ( $row ) return new Update( $row );
	}


	/**
	* Returns all (or a range of) Update objects in the DB
	*
	* @return Array|false A two-element array : results => array, a list of Update objects; totalRows => Total number of updates
	*/
	public static function getList() 
	{
		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
	
		$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM updates ORDER BY id_update ASC LIMIT 1000000";
		$st = $conn->prepare($sql);
		$st->execute();
		$list = array();
	
		while ($row = $st->fetch())
		{
			$update = new Update($row);
			$list[] = $update;
		}
	
		// Now get the total number of updates that matched the criteria
		$sql = "SELECT FOUND_ROWS() AS totalRows";
		$totalRows = $conn->query( $sql )->fetch();
		$conn = null;
		return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
	}


	/**
	* Inserts the current Update object into the database, and sets its ID property.
	*/
	public function insert() 
	{
		$this->id_update = null;
		// Does the Update object already have an ID?
		if ( !is_null( $this->id_update ) ) trigger_error ( "Update::insert(): Attempt to insert an Update object that already has its ID property set (to $this->id_update).", E_USER_ERROR );
	
		// Insert the Update
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$sql = "INSERT INTO updates ( updateName, estimatedDate, extraInformation, isWipe ) VALUES (  :updateName, :estimatedDate, :extraInformation, :isWipe )";
		$st = $conn->prepare ( $sql );
		$st->bindValue( ":updateName", $this->updateName, PDO::PARAM_STR );
		$st->bindValue( ":estimatedDate", $this->estimatedDate, PDO::PARAM_STR );
		$st->bindValue( ":extraInformation", $this->extraInformation, PDO::PARAM_STR );
		$st->bindValue( ":isWipe", $this->isWipe, PDO::PARAM_BOOL );
		$st->execute();
		$this->id_update = $conn->lastInsertId();
		$conn = null;
	}


	/**
	* Updates the current Update object in the database.
	*/
	public function update() 
	{
		// Does the Update object have an ID?
		if ( is_null( $this->id_update ) ) trigger_error ( "Update::update(): Attempt to update an Update object that does not have its ID property set.", E_USER_ERROR );
	
		// Update the Update
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$sql = "UPDATE updates SET updateName=:updateName, estimatedDate=:estimatedDate, extraInformation=:extraInformation, isWipe=:isWipe WHERE id_update = :id_update";
		$st = $conn->prepare ( $sql );
		$st->bindValue( ":updateName", $this->updateName, PDO::PARAM_STR );
		$st->bindValue( ":estimatedDate", $this->estimatedDate, PDO::PARAM_STR );
		$st->bindValue( ":extraInformation", $this->extraInformation, PDO::PARAM_STR );
		$st->bindValue( ":isWipe", $this->isWipe, PDO::PARAM_BOOL );
		$st->bindValue( ":id_update", $this->id_update, PDO::PARAM_INT );
		$st->execute();
		$conn = null;
	}


	/**
	* Deletes the current Update object from the database.
	*/
	public function delete() 
	{
		// Does the Update object have an ID?
		if ( is_null( $this->id_update ) ) trigger_error ( "Update::delete(): Attempt to delete an Update object that does not have its ID property set.", E_USER_ERROR );
	
		// Delete the Update
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$st = $conn->prepare ( "DELETE FROM updates WHERE id_update = :id_update LIMIT 1" );
		$st->bindValue( ":id_update", $this->id_update, PDO::PARAM_INT );
		$st->execute();
		$conn = null;
	}

}
?>
