<?php /** @var string $pageTitle ; @var string $view */ ?>
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
	<header class="site-header">
		<div class="wrap site-header__inner">
			<a class="brand" href="index.php">
				<span class="brand__globe" aria-hidden="true">🌍</span>
				<span>Geo<strong>world</strong></span>
			</a>
			<button id="themeToggle" class="theme-toggle" type="button" aria-label="Changer de thème">
				<span class="theme-toggle__icon">🌙</span>
			</button>
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
