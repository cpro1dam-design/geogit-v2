<?php
/**
 * Point d'entrée unique de l'application Geoworld.
 *  - accueil (grille de pays + recherche + filtres)
 *  - ?id=XX            -> fiche détaillée d'un pays
 *  - ?page=login|register|account
 *  - POST action=login|register|logout
 */
declare(strict_types=1);

session_start();

$config = require __DIR__ . '/config.php';

require __DIR__ . '/Database.php';
require __DIR__ . '/helpers.php';
require __DIR__ . '/auth.php';

Database::init($config);

// Valeurs par défaut transmises au layout.
$pageTitle   = 'Geoworld';
$view        = __DIR__ . '/views/home.php';
$bgContinent = '';      // image de fond (continent) — vide = "study"
$flash       = '';      // message d'erreur/info
$old         = [];      // ré-affichage des champs de formulaire

try {
	$action = isset($_POST['action']) ? $_POST['action'] : '';

	/* ----------------------- Actions POST ----------------------- */
	if ($action === 'login') {
		$mail = trim($_POST['mail'] ?? '');
		if (gw_csrf_check($_POST['csrf'] ?? '') && gw_login($mail, $_POST['password'] ?? '')) {
			header('Location: index.php');
			exit;
		}
		$flash       = 'Email ou mot de passe incorrect.';
		$old['mail'] = $mail;
		$pageTitle   = 'Connexion';
		$view        = __DIR__ . '/views/login.php';

	} elseif ($action === 'register') {
		$old = [
			'name'      => trim($_POST['name'] ?? ''),
			'firstname' => trim($_POST['firstname'] ?? ''),
			'mail'      => trim($_POST['mail'] ?? ''),
		];
		$password = $_POST['password'] ?? '';
		$confirm  = $_POST['confirm'] ?? '';

		$errors = [];
		if (!gw_csrf_check($_POST['csrf'] ?? '')) {
			$errors[] = 'Session expirée, merci de réessayer.';
		}
		if ($old['name'] === '' || $old['firstname'] === '') {
			$errors[] = 'Nom et prénom obligatoires.';
		}
		if (!filter_var($old['mail'], FILTER_VALIDATE_EMAIL)) {
			$errors[] = 'Adresse email invalide.';
		}
		if (strlen($password) < 4) {
			$errors[] = 'Mot de passe trop court (4 caractères minimum).';
		}
		if ($password !== $confirm) {
			$errors[] = 'Les mots de passe ne correspondent pas.';
		}

		if (!$errors) {
			$res = gw_register($old['name'], $old['firstname'], $old['mail'], $password);
			if ($res === 'ok') {
				gw_login($old['mail'], $password);
				header('Location: index.php');
				exit;
			}
			$errors[] = ($res === 'exists')
				? 'Cet email est déjà enregistré.'
				: "Erreur lors de l'inscription.";
		}

		$flash     = implode(' ', $errors);
		$pageTitle = 'Inscription';
		$view      = __DIR__ . '/views/register.php';

	} elseif ($action === 'logout') {
		gw_logout();
		header('Location: index.php');
		exit;

	} else {
		/* ----------------------- Pages GET ----------------------- */
		$page = isset($_GET['page']) ? $_GET['page'] : '';
		$id   = isset($_GET['id']) ? (int) $_GET['id'] : 0;

		if ($page === 'login') {
			$pageTitle = 'Connexion';
			$view      = __DIR__ . '/views/login.php';

		} elseif ($page === 'register') {
			$pageTitle = 'Inscription';
			$view      = __DIR__ . '/views/register.php';

		} elseif ($page === 'account') {
			if (!gw_is_auth()) {
				header('Location: index.php?page=login');
				exit;
			}
			$pageTitle = 'Mon compte';
			$view      = __DIR__ . '/views/account.php';

		} elseif ($page === 'admin') {
			$me = gw_current_user();
			if (!$me || $me['role'] !== 'admin') {
				header('Location: index.php');
				exit;
			}
			$users     = Database::allUsers();
			$pageTitle = 'Administration';
			$view      = __DIR__ . '/views/admin.php';

		} elseif ($page === 'teacher') {
			$me = gw_current_user();
			if (!$me || !in_array($me['role'], ['teacher', 'admin'], true)) {
				header('Location: index.php');
				exit;
			}
			$queries    = Database::queriesByUser($me['id']);
			$spaceTitle = 'Mes requêtes';
			$spaceHint  = 'Les requêtes que vous avez enregistrées.';
			$pageTitle  = 'Espace enseignant';
			$view       = __DIR__ . '/views/queries.php';

		} elseif ($page === 'student') {
			$me = gw_current_user();
			if (!$me) {
				header('Location: index.php?page=login');
				exit;
			}
			$queries    = Database::publicQueries();
			$spaceTitle = 'Requêtes publiques';
			$spaceHint  = 'Les requêtes partagées par les enseignants.';
			$pageTitle  = 'Espace étudiant';
			$view       = __DIR__ . '/views/queries.php';

		} elseif ($id > 0) {
			$country = Database::country($id);
			if (!$country) {
				http_response_code(404);
				$pageTitle = 'Pays introuvable';
				$view      = __DIR__ . '/views/not-found.php';
			} else {
				$cities      = Database::cities($id);
				$languages   = Database::languages($id);
				$bgContinent = $country->Continent;
				$pageTitle   = $country->Name . ' — Geoworld';
				$view        = __DIR__ . '/views/country.php';
			}

		} else {
			$countries  = Database::countries();
			$continents = Database::continents();
		}
	}
} catch (Throwable $ex) {
	error_log('Geoworld error: ' . $ex->getMessage());
	http_response_code(503);
	$pageTitle   = 'Service indisponible';
	$view        = __DIR__ . '/views/error.php';
	$errorDetail = ($config['debug'] ?? false) ? $ex->getMessage() : '';
}

require __DIR__ . '/views/layout.php';
