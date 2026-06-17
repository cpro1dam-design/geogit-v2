<?php
/**
 * Petites fonctions utilitaires partagées par les vues.
 */

/** Échappe le HTML (anti-XSS). À utiliser sur TOUTE sortie. */
function e($value): string
{
	return htmlspecialchars((string) $value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/** URL d'un drapeau via flagcdn.com à partir du code ISO alpha-2. */
function flag_url(?string $code2, string $size = 'w320'): string
{
	$code2 = strtolower(trim((string) $code2));
	return $code2 ? "https://flagcdn.com/{$size}/{$code2}.png" : '';
}

/** Lien vers la fiche d'un pays. */
function country_url(int $id): string
{
	return '?id=' . $id;
}

/** Formate un nombre avec séparateurs de milliers (espace fine). */
function num($value): string
{
	if ($value === null || $value === '') {
		return '—';
	}
	return number_format((float) $value, 0, ',', "\u{202F}");
}

/** Affiche une valeur ou un tiret si vide. */
function val($value): string
{
	$value = trim((string) $value);
	return ($value === '' || $value === '0') ? '—' : e($value);
}

/** Chemin de l'image de fond pour un continent (vide = "study"). */
function bg_image($continent): string
{
	$map = [
		''               => 'background-study.jpg',
		'Asia'           => 'background-Asie.jpg',
		'Africa'         => 'background-Afrique.jpg',
		'Europe'         => 'background-europe.jpg',
		'North America'  => 'background-amerique-nord.jpg',
		'South America'  => 'background-amerique-sud.jpg',
		'Oceania'        => 'background-oceanie.jpg',
		'Antarctica'     => 'background-Antarctique.jpg',
	];
	$file = isset($map[$continent]) ? $map[$continent] : 'background-study.jpg';
	return 'assets/bg/' . $file;
}
