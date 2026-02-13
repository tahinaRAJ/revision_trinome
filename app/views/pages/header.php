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
				<li><a class="nav-link" href="<?= BASE_URL ?>/system/admin">Admin</a></li>
			</ul>

					<ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
						<!-- keep original login icon -->
						<li><a class="nav-link" href="<?= BASE_URL ?>/auth/login"><img src="<?= BASE_URL ?>/images/user.svg" alt="User"></a></li>
						<!-- keep cart icon -->
						<li><a class="nav-link" href="<?= BASE_URL ?>/shop/cart"><img src="<?= BASE_URL ?>/images/cart.svg" alt="Cart"></a></li>
					</ul>

					<!-- user profile dropdown aligned to the far right -->
					<ul class="navbar-nav ms-auto mb-2 mb-md-0">
						<?php
						$user = $_SESSION['user'] ?? null;
						$rawName = $user ? trim(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')) : '';
						$displayName = $rawName !== '' ? $rawName : ($user['email'] ?? '');
						if ($displayName === '') $displayName = 'Mon compte';
						$displayName = htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8');

						$avatar = $user['avatar'] ?? '';
						if ($avatar !== '') {
							if (preg_match('#^https?://#i', $avatar) || strpos($avatar, '/') === 0) {
								$resolved = $avatar;
							} else {
								$resolved = rtrim(BASE_URL, '/') . '/' . ltrim($avatar, '/');
							}
							$avatarUrl = htmlspecialchars($resolved, ENT_QUOTES, 'UTF-8');
						} else {
							$avatarUrl = BASE_URL . '/images/user.svg';
						}
						?>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userMenuRight" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								<img src="<?= $avatarUrl ?>" alt="<?= $displayName ?>" class="rounded-circle" width="32" height="32">
								<span class="ms-2"><?= $displayName ?></span>
							</a>
							<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuRight">
								<?php if (!empty($_SESSION['user'])): ?>
									<li><a class="dropdown-item" href="<?= BASE_URL ?>/user/profile">Profile</a></li>
									<li><a class="dropdown-item" href="<?= BASE_URL ?>/auth/logout">Logout</a></li>
								<?php else: ?>
									<li><a class="dropdown-item" href="<?= BASE_URL ?>/auth/login">Login</a></li>
									<li><a class="dropdown-item" href="<?= BASE_URL ?>/auth/signup">Sign up</a></li>
								<?php endif; ?>
							</ul>
						</li>
					</ul>
		</div>
	</div>
</nav>
