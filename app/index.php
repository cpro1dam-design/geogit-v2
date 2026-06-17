<?php
/**
 * Point d'entrée unique de l'application Geoworld.
 *  - sans paramètre        -> grille de tous les pays
 *  - ?id=XX                 -> fiche détaillée d'un pays
 */
declare(strict_types=1);

$config = require __DIR__ . '/config.php';

require __DIR__ . '/Database.php';
require __DIR__ . '/helpers.php';

Database::init($config);

// Données communes à toutes les pages.
$pageTitle = 'Geoworld';
$view      = __DIR__ . '/views/home.php';

try {
	$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

	if ($id > 0) {
		// --- Vue détail ---
		$country = Database::country($id);
		if (!$country) {
			http_response_code(404);
			$pageTitle = 'Pays introuvable';
			$view      = __DIR__ . '/views/not-found.php';
		} else {
			$cities    = Database::cities($id);
			$languages = Database::languages($id);
			$pageTitle = $country->Name . ' — Geoworld';
			$view      = __DIR__ . '/views/country.php';
		}
	} else {
		// --- Vue grille ---
		$countries  = Database::countries();
		$continents = Database::continents();
	}
} catch (Throwable $ex) {
	error_log('Geoworld error: ' . $ex->getMessage());
	http_response_code(503);
	$pageTitle  = 'Service indisponible';
	$view       = __DIR__ . '/views/error.php';
	$errorDetail = ($config['debug'] ?? false) ? $ex->getMessage() : '';
}

require __DIR__ . '/views/layout.php';
