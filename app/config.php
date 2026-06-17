<?php
/**
 * Configuration de l'application Geoworld.
 * Les identifiants peuvent être surchargés par des variables d'environnement
 * (recommandé en production) ou définis ici par défaut.
 */

return [
	'db' => [
		'host'    => getenv('GEOWORLD_DB_HOST') ?: 'sql202.infinityfree.com',
		'name'    => getenv('GEOWORLD_DB_NAME') ?: 'if0_41035004_geoworld',
		'user'    => getenv('GEOWORLD_DB_USER') ?: 'if0_41035004',
		'pass'    => getenv('GEOWORLD_DB_PASS') ?: 'geoworld589',
		'charset' => 'utf8mb4',
	],
	// Affiche le détail des erreurs (à mettre à false en production).
	'debug' => filter_var(getenv('GEOWORLD_DEBUG') ?: false, FILTER_VALIDATE_BOOLEAN),
];
