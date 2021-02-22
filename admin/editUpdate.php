<!DOCTYPE html>
<?php include "include/header.php" ?>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
	<a class="navbar-brand" href="index.php"><b>Tarkov Development Roadmap</b></a>
	
	<a class="trkv_btn right-float" href="admin.php"><b>Back to Dashboard</b></a>
</nav>

<div class="card mx-4 my-2">
	<h1 class="card-header"><?php echo $results['pageTitle']?></h1>
	<div class="card-body">
		<form action="admin.php?action=<?php echo $results['formAction']?>" method="post" enctype="multipart/form-data">
			<input type="hidden" id="id_update" name="id_update" value="<?php echo $results['updates']->id_update ?>"/>
		
			<?php if ( isset( $results['errorMessage'] ) ) { ?>		
				<div class="alert alert-danger" role="alert">
					<?php echo $results['errorMessage'] ?>
					
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php } ?>
		
			<div class="form-group">
				<label for="updateName">Update Name</label>
				<input type="text" class="form-control trkv_textfield" name="updateName" id="updateName" placeholder="Name/Number of the Update" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['updates']->updateName )?>"/>
			</div>
			<div class="form-group">
				<label for="extraInformation">Update Content</label>
				<textarea class="form-control trkv_textfield" name="extraInformation" id="extraInformation" placeholder="What the update will contain" maxlength="100000" rows="6"><?php echo htmlspecialchars( $results['updates']->extraInformation )?></textarea>
			</div>
			<div class="form-group">
				<label for="estimatedDate">Estimated Date</label>
				<textarea class="form-control trkv_textfield" name="estimatedDate" id="estimatedDate" placeholder="Date or estimation of when the update will be live" maxlength="255" rows="1"><?php echo htmlspecialchars( $results['updates']->estimatedDate )?></textarea>
			</div>
			<div class="form-group">
				<label for="isWipe">Is this a wipe?</label>
				<br>
				<div class="form-check form-check-inline">
					<?php if ($results["updates"]->isWipe == 1) { ?>
						<input class="form-check-input" type="radio" id="isWipe" name="isWipe" value="1" checked>
					<?php } else { ?>
						<input class="form-check-input" type="radio" id="isWipe" name="isWipe" value="1">
					<?php } ?>
					<label class="form-check-label" for="inlineRadio1">Yes</label>
				</div>
				<div class="form-check form-check-inline">
					<?php if ($results["updates"]->isWipe == 0) { ?>
						<input class="form-check-input" type="radio" id="isWipe" name="isWipe" value="0" checked>
					<?php } else { ?>
						<input class="form-check-input" type="radio" id="isWipe" name="isWipe" value="0">
					<?php } ?>
					<label class="form-check-label" for="inlineRadio2">No</label>
				</div>
			</div>
			<div class="form-group">
				<label for="updateImages" class="trk_file_upload">Images</label>
				<span id="selected-images"></span>
				<input class="form-control-file" type="file" name="updateImages[]" id="updateImages" accept="image/*, .gif" multiple></input>
			</div>
			<?php if ( $results['updates'] && $imagePath = $results['updates']->has_image() ) { ?>
				<div class="form-group">
					<?php foreach($results['updates']->getAllImages() as $imagePath) { ?>
						<div class="img_wrp">
							<img id="userImage" width="180" src="<?php echo $imagePath ?>" alt="Update image"/>
							<a onclick="deleteImage('<?php echo $imagePath ?>')"><i class="fas fa-times-circle close_img"></i></a>
						</div>
					<?php } ?>
				</div>
    			<div class="form-group">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="deleteImage" id="deleteImage" value="yes"/>
						<label class="form-check-label" for="deleteImage">Delete ALL images</label>
					</div>
				</div>
			<?php } ?>

			<div class="buttons">
				<input class="trkv_btn" type="submit" name="saveChanges" value="Save changes" />
				<input class="trkv_btn" type="submit" formnovalidate name="cancel" value="Cancel" />
			</div>
			
			<?php if ( $results['updates']->id_update ) { ?>
				<a onclick="confirmDelete()"><button class="trkv_btn danger" type="button">Delete this update</button></a>
			<?php } ?>
			
		</form>
	</div>
</div>

<?php include "include/footer.php" ?>

<!-- Modals -->

<!-- Update exclusion confirmation modal -->
<?php include "modals/confirmDeleteUpdate_Modal.php" ?>

<!-- End Modals -->