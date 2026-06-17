<?php
/**
 * Authentification Geoworld.
 * - Connexion compatible avec les comptes existants (mots de passe en clair)
 *   ET les nouveaux comptes (hachés via password_hash).
 * - Jeton CSRF pour protéger les formulaires.
 */

/** Jeton CSRF de la session (créé si absent). */
function gw_csrf_token()
{
	if (empty($_SESSION['csrf'])) {
		$_SESSION['csrf'] = bin2hex(random_bytes(16));
	}
	return $_SESSION['csrf'];
}

/** Vérifie un jeton CSRF reçu. */
function gw_csrf_check($token)
{
	return !empty($_SESSION['csrf']) && is_string($token) && hash_equals($_SESSION['csrf'], $token);
}

/** Utilisateur connecté (tableau) ou null. */
function gw_current_user()
{
	return isset($_SESSION['user']) ? $_SESSION['user'] : null;
}

/** Vrai si un utilisateur est connecté. */
function gw_is_auth()
{
	return gw_current_user() !== null;
}

/** Tente une connexion. Retourne true/false. */
function gw_login($mail, $password)
{
	$user = Database::userByEmail($mail);
	if (!$user) {
		return false;
	}

	$stored = (string) $user->password;
	$info   = password_get_info($stored);
	$ok     = $info['algo']
		? password_verify($password, $stored)        // compte récent (haché)
		: hash_equals($stored, (string) $password);  // compte hérité (clair)

	if (!$ok) {
		return false;
	}

	$_SESSION['user'] = [
		'id'        => $user->id,
		'name'      => $user->name,
		'firstname' => $user->firstname,
		'mail'      => $user->mail,
		'role'      => isset($user->role) ? $user->role : 'student',
	];
	session_regenerate_id(true);
	return true;
}

/**
 * Inscrit un utilisateur.
 * Retourne 'ok', 'exists' ou 'error'.
 */
function gw_register($name, $firstname, $mail, $password)
{
	if (Database::userExists($mail)) {
		return 'exists';
	}
	$hash = password_hash($password, PASSWORD_DEFAULT);
	return Database::createUser($name, $firstname, $mail, $hash) ? 'ok' : 'error';
}

/** Déconnexion. */
function gw_logout()
{
	unset($_SESSION['user']);
}
