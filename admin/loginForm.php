<?php include "include/header.php" ?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
	<a class="navbar-brand" href="index.php"><b>Tarkov Development Roadmap</b></a>
</nav>

<div class="row h-100" style="margin-left: 0px; margin-right: 0px;">
<form action="admin.php?action=login" method="post" class="col mx-auto my-auto">
	<input type="hidden" name="login" value="true"/>
		
	<div class="card mx-auto" style="width: 50%">
		<?php if ( isset( $results['errorMessage'] ) ) { ?>
			<div class="alert alert-danger m-2" role="alert">
				<?php echo $results['errorMessage'] ?>
				
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php } ?>
		<?php if ( isset( $results['statusMessage'] ) ) { ?>
			<div class="alert alert-success m-2" role="alert">
				<?php echo $results['statusMessage'] ?>
				
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php } ?>
	
        <h5 class="card-header"><i class="fas fa-lock"></i> Login</h5>
        <div class="card-body">
			<div class="form-group">
				<label for="email">Email</label>
				<input type="text" name="email" id="email" class="form-control trkv_textfield" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" required autofocus>
            </div> 
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" name="password" id="password" class="form-control trkv_textfield" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required>
			</div>
			<button type="submit" name="login" class="trkv_btn">Login</button>
        </div>
    </div>    
</form>
</div>
<?php include "include/footer.php" ?>