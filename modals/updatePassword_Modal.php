<!-- Start modal template -->
<div class="modal micromodal-slide" id="modal-update-password" aria-hidden="true">
	<div class="modal__overlay" tabindex="-1">
		<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-update-password-title" >
			<header class="modal__header">
				<h2 class="modal__title" id="modal-update-password-title">
					You are using a temporary password!
				</h2>
			</header>
			<div class="alert d-none alert-danger m-1" id="alert-card" role="alert">
				<div class="row">
				<div id="errorMessage">Temporary Error Text</div>
				
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>
			</div>
			<main class="modal__content" id="modal-update-password-content">
				<p>
					It seems like this is your first login, and as such, you have a temporary password registered to your login. We require all admins to update their passwords immediatly.
				</p>
				<form>
					<div class="form-group">
						<label for="old_pass">Old (current) Password</label>
						<input type="password" name="old_pass" id="old_pass" class="form-control trkv_textfield" placeholder="Old password" aria-label="Old Password" aria-describedby="basic-addon1" required autofocus>
					</div>
					<div class="form-group">
						<label for="new_password">New Password</label>
						<input type="password" name="new_password" id="new_password" class="form-control trkv_textfield" placeholder="New Password" aria-label="New Password" aria-describedby="basic-addon1" required>
					</div>
					<div class="form-group">
						<label for="confirm_new_password">Confirm New Password</label>
						<input type="password" name="confirm_new_password" id="confirm_new_password" class="form-control trkv_textfield" placeholder="Confirm new Password" aria-label="Confirm New Password" aria-describedby="basic-addon1" required>
					</div>
				</form>
			</main>
			<footer class="modal__footer">
				<button class="modal__btn" onclick="updatePassword(<?php echo $_SESSION['id_cad']; ?>)" aria-label="Update the password">Submit</button>
			</footer>
		</div>
	</div>
</div>
<!-- End modal template -->