<?php
/** @var string $pageTitle ; @var string $view ; @var string $bgContinent */
$user = gw_current_user();
$bg   = bg_image(isset($bgContinent) ? $bgContinent : '');
?>
<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Explorez les pays du monde : population, capitales, villes et langues.">
	<title><?= e($pageTitle) ?></title>
	<link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌍</text></svg>">
	<link rel="preconnect" href="https://flagcdn.com" crossorigin>
	<link rel="stylesheet" href="assets/app.css">
</head>
<body>
	<div id="gwLoader" class="gw-loader" role="status" aria-live="polite" aria-label="Chargement de Geoworld">
		<div class="gw-loader__stage" aria-hidden="true">
			<div class="gw-loader__ring"><span></span></div>
			<div class="gw-loader__earth"></div>
		</div>
		<p class="gw-loader__title">Geo<strong>world</strong></p>
	</div>

	<div class="gw-bg" id="gwBg" style="background-image:url('<?= e($bg) ?>')"></div>

	<header class="site-header">
		<div class="wrap site-header__inner">
			<a class="brand" href="index.php">
				<span class="brand__globe" aria-hidden="true">🌍</span>
				<span>Geo<strong>world</strong></span>
			</a>

			<nav class="site-nav" aria-label="Navigation principale">
				<?php if ($user): ?>
					<?php if ($user['role'] === 'admin'): ?>
						<a class="site-nav__link" href="index.php?page=admin">👑 Administration</a>
					<?php endif; ?>
					<?php if (in_array($user['role'], ['teacher', 'admin'], true)): ?>
						<a class="site-nav__link" href="index.php?page=teacher">📋 Mes requêtes</a>
					<?php endif; ?>
					<?php if ($user['role'] === 'student'): ?>
						<a class="site-nav__link" href="index.php?page=student">🎓 Requêtes publiques</a>
					<?php endif; ?>
					<a class="site-nav__link" href="index.php?page=account">
						👤 <?= e($user['firstname'] ?: $user['name']) ?>
					</a>
					<form method="post" action="index.php" class="site-nav__logout">
						<input type="hidden" name="action" value="logout">
						<button type="submit" class="btn btn--ghost">Déconnexion</button>
					</form>
				<?php else: ?>
					<a class="site-nav__link" href="index.php?page=login">Connexion</a>
					<a class="btn btn--primary" href="index.php?page=register">Inscription</a>
				<?php endif; ?>

				<button id="themeToggle" class="theme-toggle" type="button" aria-label="Changer de thème">
					<span class="theme-toggle__icon">🌙</span>
				</button>
			</nav>
		</div>
	</header>

	<main class="wrap">
		<?php require $view; ?>
	</main>

	<footer class="site-footer">
		<div class="wrap">
			<p>Geoworld · Données <em>world database</em> · <?= date('Y') ?></p>
		</div>
	</footer>

	<script src="assets/app.js" defer></script>
</body>
</html>
