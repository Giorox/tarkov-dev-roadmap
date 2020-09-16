<?php require_once( "config.php" ); ?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Website to visually display information on the progress and expected timeline of the development of the game Escape from Tarkov owned by BattleState Games.">
		<meta name="author" content="Giorox and MacV2">
		<title>Tarkov Developer Roadmap</title>

		<link rel="canonical" href=""> <!-- FILL THIS IN ONCE WE GO LIVE -->

		<!-- Bootstrap core CSS -->
		<link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Custom styles for this template -->
		<link href="assets/dist/css/starter-template.css" rel="stylesheet">
		<!-- Roadmap.JS CSS -->
		<link href="assets/dist/css/jquery.roadmap.min.css" rel="stylesheet">
		<!-- Micromodal JS CSS -->
		<link href="assets/dist/css/micromodal.css" rel="stylesheet">
		
		<!-- Scripts -->
		<!-- jQuery -->
		<script src="assets/dist/js/jquery-3.5.1.js"></script>
		<script src="assets/dist/js/jquery-3.5.1.min.js"></script>

		<!-- Bootstrap.js -->
		<script src="assets/dist/js/bootstrap.bundle.min.js"></script>
		
		<!-- Roadmap.JS -->
		<script src="assets/dist/js/jquery.roadmap.js"></script>
		<!--<script src="assets/dist/js/jquery.roadmap.min.js"></script>
		
		<!-- Micromodal JS -->
		<script src="assets/dist/js/micromodal.min.js"></script>
		
		<!-- Custom Scripts -->
		<script src="assets/dist/js/customFuncs.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
			<a class="navbar-brand" href="#"><b>Tarkov Development Roadmap</b></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarsExampleDefault">
				<ul class="navbar-nav mr-auto vertical-separator">
					<li class="nav-item active">
						<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Link</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
						<div class="dropdown-menu" aria-labelledby="dropdown01">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
				</ul>
			</div>
		</nav>

		<main role="main" class="container">
			<div class="starter-template">
				<h1>Escape From Tarkov Unofficial Developer Roadmap</h1>
				<p class="lead off-white">Below we have aggregated information on future Tarkov updates.<br> All information is crowd-sourced and self-sourced from openly available information.</p>
			</div>
			<div id="tarkov-roadmap-timeline"></div>
		</main><!-- /.main -->
	</body>
	<footer class="footer">
		<hr class="single-line">
		<div class="container">
			<span>&copy; 2020 - <span id="current-date"></span> -- <b>Tarkov Dev Roadmap</b></span>
			<br>
			<span>ver 0.3.0</span>
		</div>
	</footer>
	
	<!-- Start modal template -->
	<div class="modal micromodal-slide" id="modal-extra-info" aria-hidden="true">
		<div class="modal__overlay" tabindex="-1" data-micromodal-close>
			<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-extra-info-title" >
				<header class="modal__header">
					<h2 class="modal__title" id="modal-extra-info-title">
						Lorem Ipsum
					</h2>

					<button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
				</header>
				<h6 id="modal-extra-info-expected-date"></h6>
				<main class="modal__content" id="modal-extra-info-content">
					<p>
						Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet 
					</p>
				</main>
				<footer class="modal__footer">
					<button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Close</button>
				</footer>

			</div>
		</div>
	</div>
	<!-- End modal template -->

</html>
