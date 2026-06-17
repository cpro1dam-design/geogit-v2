<?php
/**
 * Connexion à la base de données.
 *
 * Détection automatique de l'environnement :
 *   - en local (localhost / 127.0.0.1)  -> MySQL local (root, base geoworld)
 *   - en ligne                          -> hébergement InfinityFree
 *
 * On peut forcer le mode local en définissant la variable
 * d'environnement GEOWORLD_ENV=local.
 */

// --- Détection local vs production ---
$serverName = $_SERVER['SERVER_NAME'] ?? ($_SERVER['HTTP_HOST'] ?? '');
$serverName = strtolower(explode(':', $serverName)[0]); // retire le port éventuel
$isLocal = getenv('GEOWORLD_ENV') === 'local'
        || in_array($serverName, ['localhost', '127.0.0.1', '::1'], true)
        || in_array($_SERVER['SERVER_ADDR'] ?? '', ['127.0.0.1', '::1'], true);

if ($isLocal) {
  define('DB_HOST', '127.0.0.1');
  define('DB_NAME', 'geoworld');
  define('DB_USER', 'root');
  define('DB_PASSWORD', '');
  define('DEBUG', true);
} else {
  define('DB_HOST', 'sql202.infinityfree.com');
  define('DB_NAME', 'if0_41035004_geoworld');
  define('DB_USER', 'if0_41035004');
  define('DB_PASSWORD', 'geoworld589');
  define('DEBUG', false);
}

define('DB_DSN', 'mysql:host=' . DB_HOST . '; dbname=' . DB_NAME . '; charset=utf8');

if (DEBUG) {
  ini_set('display_errors', 1);
}

$dbError = '';

function connect()
{
  global $dbError;
  $opt = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, //ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    PDO::ATTR_EMULATE_PREPARES => false
  );
  try {
    return new PDO(DB_DSN, DB_USER, DB_PASSWORD, $opt);
  } catch (PDOException $e) {
    $dbError = 'Oups ! Connexion SGBD impossible !';
    if (DEBUG) :
      $dbError .= "<br/>" . $e->getMessage();
    endif;
  }
}

// initialisation de la variable globale $pdo
$pdo = connect();

if ($dbError) {
  die('<div class="ui red inverted segment"> <p>'
          . $dbError
          . '</p></div></body></html>');
}
