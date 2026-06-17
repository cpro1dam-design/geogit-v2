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
		$sql = 'SELECT id, Name, Code2, Continent, Capital, Region, Population
		        FROM country ORDER BY Name';
		return self::pdo()->query($sql)->fetchAll();
	}

	/** Fiche complète d'un pays. */
	public static function country($id)
	{
		$stmt = self::pdo()->prepare('SELECT * FROM country WHERE id = :id');
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
}
