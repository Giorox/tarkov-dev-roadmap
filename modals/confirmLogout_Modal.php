<!-- Start modal template -->
<div class="modal micromodal-slide" id="modal-confirm-logout" aria-hidden="true">
	<div class="modal__overlay" tabindex="-1" data-micromodal-close>
		<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-confirm-logout-title" >
			<header class="modal__header">
				<h2 class="modal__title" id="modal-confirm-logout-title">
					Are you sure?
				</h2>

				<button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
			</header>
			<main class="modal__content" id="modal-confirm-logout-content">
				<p>
					Are you sure you want to logout?
				</p>
			</main>
			<footer class="modal__footer">
				<button class="modal__btn mx-2" onclick="logoutAdmin()" aria-label="Logout of the dashboard">Yes</button>
				<button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">No</button>
			</footer>
		</div>
	</div>
</div>
<!-- End modal template -->