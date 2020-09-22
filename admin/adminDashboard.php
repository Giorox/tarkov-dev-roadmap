<?php include "include/header.php"; ?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
	<a class="navbar-brand" href="index.php"><b>Tarkov Development Roadmap</b></a>
	
	<a class="trkv_btn right-float" href="admin.php?action=logout"><b>Logout</b></a>
</nav>

<?php if ( isset( $results['errorMessage'] ) ) { ?>		
	<div class="alert alert-danger" role="alert">
		<?php echo $results['errorMessage'] ?>
			
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
<?php } ?>


<?php if ( isset( $results['statusMessage'] ) ) { ?>		
	<div class="alert alert-warning" role="alert">
		<?php echo $results['statusMessage'] ?>
			
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
<?php } ?>

<div class="row mx-0">
	<div class="card col mx-2">
		<h3 class="card-header">Updates</h3>
		<div class="card-body list-group">
			<?php foreach ( $results['updates'] as $update ) { ?>
				<a onclick="location='admin.php?action=editUpdate&amp;id_update=<?php echo $update->id_update?>'" class="list-group-item list-group-item-action flex-column align-items-start">
					<div class="d-flex w-100 justify-content-between">
						<h5 class="mb-1"><?php echo $update->updateName?></h5>
						<small><?php echo $update->estimatedDate?></small>
					</div>
				</a>
			<?php } ?>
		</div>
	</div>
	
	<div class="card col-2 mx-2">
		<h3 class="card-header">Dashboard</h3>
		<div class="card-body">
			<p>You are logged in as <b><?php echo $_SESSION["username"] ?></b>.</p>
			<p><?php echo $results['totalRows']?> registered update<?php echo ( $results['totalRows'] > 1 ) ? 's' : '' ?>.</p>
			<a href="admin.php?action=newUpdate"><button class="trkv_btn" type="button">Create New Update</button></a>
		</div>
	</div>
</div>


<?php include "include/footer.php" ?>