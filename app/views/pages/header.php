<?php
$pageTitle = $pageTitle ?? 'Furni';
$activePage = $activePage ?? '';
$isActive = function (string $name) use ($activePage): string {
		return $name === $activePage ? 'active' : '';
};
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Untree.co">
	<link rel="shortcut icon" href="favicon.png">

	<meta name="description" content="" />
	<meta name="keywords" content="bootstrap, bootstrap4" />

	<!-- Bootstrap CSS -->
	<link href="<?= BASE_URL ?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
	<link href="<?= BASE_URL ?>/css/tiny-slider.css" rel="stylesheet">
	<link href="<?= BASE_URL ?>/css/style.css" rel="stylesheet">
	<title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
</head>

<body>
<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">
	<div class="container">
		<a class="navbar-brand" href="<?= BASE_URL ?>/home/index">Furni<span>.</span></a>

		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarsFurni">
			<ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
				<li class="nav-item <?= $isActive('home') ?>">
					<a class="nav-link" href="<?= BASE_URL ?>/home/index">Home</a>
				</li>
				<li class="<?= $isActive('shop') ?>"><a class="nav-link" href="<?= BASE_URL ?>/shop/shop">Shop</a></li>
				<li class="<?= $isActive('about') ?>"><a class="nav-link" href="<?= BASE_URL ?>/pages/about">About us</a></li>
				<li class="<?= $isActive('services') ?>"><a class="nav-link" href="<?= BASE_URL ?>/pages/services">Services</a></li>
				<li class="<?= $isActive('blog') ?>"><a class="nav-link" href="<?= BASE_URL ?>/pages/blog">Blog</a></li>
				<li class="<?= $isActive('contact') ?>"><a class="nav-link" href="<?= BASE_URL ?>/pages/contact">Contact us</a></li>
			</ul>

			<ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
				<li><a class="nav-link" href="<?= BASE_URL ?>/auth/login"><img src="<?= BASE_URL ?>/images/user.svg" alt="User"></a></li>
				<li><a class="nav-link" href="<?= BASE_URL ?>/shop/cart"><img src="<?= BASE_URL ?>/images/cart.svg" alt="Cart"></a></li>
			</ul>
		</div>
	</div>
</nav>