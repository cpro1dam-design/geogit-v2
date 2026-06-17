<?php
/**
 * Couche d'accès aux données Geoworld.
 * Connexion PDO paresseuse + requêtes préparées (aucune injection possible).
 */
class Database
{
	/** @var PDO|null */
	private static $pdo = null;

	/** @var array */
	private static $config = [];

	public static function init(array $config)
	{
		self::$config = $config;
	}

	private static function pdo()
	{
		if (self::$pdo instanceof PDO) {
			return self::$pdo;
		}

		$db  = self::$config['db'];
		$dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $db['host'], $db['name'], $db['charset']);

		$options = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];

		self::$pdo = new PDO($dsn, $db['user'], $db['pass'], $options);
		return self::$pdo;
	}

	/** Liste des continents distincts (pour les filtres). */
	public static function continents()
	{
		$rows = self::pdo()
			->query("SELECT DISTINCT Continent FROM country WHERE Continent <> '' ORDER BY Continent")
			->fetchAll();
		return array_map(function ($r) {
			return $r->Continent;
		}, $rows);
	}

	/** Tous les pays (données légères pour la grille + filtrage client). */
	public static function countries()
	{
		// Capital est un id de ville : on le résout en nom via une jointure.
		$sql = 'SELECT c.id, c.Name, c.Code2, c.Continent, c.Region, c.Population,
		               cap.Name AS Capital
		        FROM country c
		        LEFT JOIN city cap ON cap.id = c.Capital
		        ORDER BY c.Name';
		return self::pdo()->query($sql)->fetchAll();
	}

	/** Fiche complète d'un pays (avec nom de la capitale résolu). */
	public static function country($id)
	{
		$sql = 'SELECT c.*, cap.Name AS CapitalName
		        FROM country c
		        LEFT JOIN city cap ON cap.id = c.Capital
		        WHERE c.id = :id';
		$stmt = self::pdo()->prepare($sql);
		$stmt->execute([':id' => $id]);
		$row = $stmt->fetch();
		return $row ?: null;
	}

	/** Villes d'un pays, triées par population. */
	public static function cities($countryId)
	{
		$stmt = self::pdo()->prepare(
			'SELECT Name, District, Population FROM city WHERE idCountry = :id ORDER BY Population DESC'
		);
		$stmt->execute([':id' => $countryId]);
		return $stmt->fetchAll();
	}

	/** Langues d'un pays (un seul JOIN, triées par pourcentage). */
	public static function languages($countryId)
	{
		$sql = 'SELECT l.Name AS language, cl.IsOfficial, cl.Percentage
		        FROM countrylanguage cl
		        JOIN language l ON l.id = cl.idLanguage
		        WHERE cl.idCountry = :id
		        ORDER BY cl.Percentage DESC';
		$stmt = self::pdo()->prepare($sql);
		$stmt->execute([':id' => $countryId]);
		return $stmt->fetchAll();
	}

	/* ----------------------- Utilisateurs ----------------------- */

	/** Récupère un utilisateur par son email. */
	public static function userByEmail($mail)
	{
		$stmt = self::pdo()->prepare('SELECT * FROM users WHERE mail = :m');
		$stmt->execute([':m' => $mail]);
		$row = $stmt->fetch();
		return $row ?: null;
	}

	/** Indique si un email est déjà enregistré. */
	public static function userExists($mail)
	{
		$stmt = self::pdo()->prepare('SELECT COUNT(*) FROM users WHERE mail = :m');
		$stmt->execute([':m' => $mail]);
		return (int) $stmt->fetchColumn() > 0;
	}

	/** Crée un utilisateur (mot de passe déjà haché). */
	public static function createUser($name, $firstname, $mail, $password, $role = 'student')
	{
		$stmt = self::pdo()->prepare(
			'INSERT INTO users (name, firstname, mail, password, role) VALUES (:n, :f, :m, :p, :r)'
		);
		return $stmt->execute([
			':n' => $name,
			':f' => $firstname,
			':m' => $mail,
			':p' => $password,
			':r' => $role,
		]);
	}

	/** Tous les utilisateurs (espace admin). */
	public static function allUsers()
	{
		return self::pdo()
			->query('SELECT id, name, firstname, mail, role FROM users ORDER BY role, name')
			->fetchAll();
	}

	/** Requêtes enregistrées d'un utilisateur (espace enseignant). */
	public static function queriesByUser($userId)
	{
		$stmt = self::pdo()->prepare('SELECT * FROM query WHERE id_user = :id ORDER BY id DESC');
		$stmt->execute([':id' => $userId]);
		return $stmt->fetchAll();
	}

	/** Requêtes publiques (espace étudiant). */
	public static function publicQueries()
	{
		return self::pdo()
			->query("SELECT * FROM query WHERE query_statut = 'public' ORDER BY id DESC")
			->fetchAll();
	}
}
