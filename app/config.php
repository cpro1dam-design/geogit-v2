<?php
/**
 * Configuration de l'application Geoworld.
 *
 * Le profil par défaut est « production » (hébergement InfinityFree).
 * Définissez la variable d'environnement GEOWORLD_ENV=local pour viser
 * le MySQL local (root, sans mot de passe, base geoworld).
 *
 * Chaque réglage reste surchargeable individuellement par sa variable
 * d'environnement (GEOWORLD_DB_HOST, GEOWORLD_DB_USER, …).
 */

/**
 * Retourne la variable d'environnement si elle est DÉFINIE (même vide),
 * sinon la valeur par défaut.
 */
function geoworld_env($key, $default)
{
	$value = getenv($key);
	return $value !== false ? $value : $default;
}

// Détection automatique : localhost / 127.0.0.1 => profil local.
$serverName = strtolower(explode(':', $_SERVER['SERVER_NAME'] ?? ($_SERVER['HTTP_HOST'] ?? ''))[0]);
$isLocalHost = in_array($serverName, ['localhost', '127.0.0.1', '::1'], true)
            || in_array($_SERVER['SERVER_ADDR'] ?? '', ['127.0.0.1', '::1'], true);

$profile = geoworld_env('GEOWORLD_ENV', $isLocalHost ? 'local' : 'production');

if ($profile === 'local') {
	// MySQL local (EasyPHP / XAMPP) — mot de passe vide assumé ici,
	// donc pas besoin de transmettre une chaîne vide par l'environnement.
	$defaults = [
		'host' => '127.0.0.1',
		'name' => 'geoworld',
		'user' => 'root',
		'pass' => '',
	];
} else {
	// Hébergement en ligne.
	$defaults = [
		'host' => 'sql202.infinityfree.com',
		'name' => 'if0_41035004_geoworld',
		'user' => 'if0_41035004',
		'pass' => 'geoworld589',
	];
}

return [
	'db' => [
		'host'    => geoworld_env('GEOWORLD_DB_HOST', $defaults['host']),
		'name'    => geoworld_env('GEOWORLD_DB_NAME', $defaults['name']),
		'user'    => geoworld_env('GEOWORLD_DB_USER', $defaults['user']),
		'pass'    => geoworld_env('GEOWORLD_DB_PASS', $defaults['pass']),
		'charset' => 'utf8mb4',
	],
	// Affiche le détail des erreurs (à mettre à false en production).
	'debug' => filter_var(geoworld_env('GEOWORLD_DEBUG', false), FILTER_VALIDATE_BOOLEAN),
];
