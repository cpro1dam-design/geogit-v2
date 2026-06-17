<?php
/**
 * Plugin Name:       Geoworld pour Divi
 * Description:        Affiche la base de pays / villes / langues via le shortcode [geoworld]. À placer dans un module Code ou Texte Divi.
 * Version:           1.0.0
 * Requires PHP:      7.4
 * Author:            Damien
 * License:           GPL-2.0-or-later
 *
 * UTILISATION :
 *   1. Zippez le dossier "geoworld-divi" et installez-le via Extensions > Ajouter.
 *   2. Renseignez vos identifiants DB ci-dessous (ou dans wp-config.php).
 *   3. Dans Divi, ajoutez un module "Code" (ou "Texte") et tapez :  [geoworld]
 *
 * PARAMÈTRES DU SHORTCODE :
 *   [geoworld]                      -> grille de tous les pays
 *   [geoworld continent="Europe"]   -> pays d'un continent
 *   La navigation (clic sur un pays) se fait via le paramètre d'URL ?gw_country=ID,
 *   géré automatiquement sur la même page.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Pas d'accès direct.
}

/*
 * --------------------------------------------------------------------------
 *  CONFIGURATION BASE DE DONNÉES
 *  Idéalement, définissez ces constantes dans wp-config.php plutôt qu'ici.
 * --------------------------------------------------------------------------
 */
if ( ! defined( 'GEOWORLD_DB_HOST' ) ) {
	define( 'GEOWORLD_DB_HOST', 'sql202.infinityfree.com' );
}
if ( ! defined( 'GEOWORLD_DB_NAME' ) ) {
	define( 'GEOWORLD_DB_NAME', 'if0_41035004_geoworld' );
}
if ( ! defined( 'GEOWORLD_DB_USER' ) ) {
	define( 'GEOWORLD_DB_USER', 'if0_41035004' );
}
if ( ! defined( 'GEOWORLD_DB_PASS' ) ) {
	define( 'GEOWORLD_DB_PASS', '' ); // À renseigner.
}

/**
 * Connexion PDO paresseuse (créée une seule fois, à la demande).
 *
 * @return PDO|WP_Error
 */
function geoworld_db() {
	static $pdo = null;

	if ( null !== $pdo ) {
		return $pdo;
	}

	$dsn = sprintf(
		'mysql:host=%s;dbname=%s;charset=utf8mb4',
		GEOWORLD_DB_HOST,
		GEOWORLD_DB_NAME
	);

	$options = array(
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
		PDO::ATTR_EMULATE_PREPARES   => false,
	);

	try {
		$pdo = new PDO( $dsn, GEOWORLD_DB_USER, GEOWORLD_DB_PASS, $options );
	} catch ( PDOException $e ) {
		// On ne révèle jamais le détail de l'erreur au visiteur.
		error_log( 'Geoworld DB error: ' . $e->getMessage() );
		return new WP_Error( 'geoworld_db', __( 'Service géographique momentanément indisponible.', 'geoworld' ) );
	}

	return $pdo;
}

/*
 * --------------------------------------------------------------------------
 *  COUCHE DE DONNÉES (requêtes préparées uniquement)
 * --------------------------------------------------------------------------
 */

/** Liste de tous les pays, ou d'un continent donné. */
function geoworld_get_countries( $continent = '' ) {
	$pdo = geoworld_db();
	if ( is_wp_error( $pdo ) ) {
		return $pdo;
	}

	if ( '' !== $continent ) {
		$stmt = $pdo->prepare( 'SELECT id, Name, Code2 FROM country WHERE Continent = :c ORDER BY Name' );
		$stmt->execute( array( ':c' => $continent ) );
	} else {
		$stmt = $pdo->query( 'SELECT id, Name, Code2 FROM country ORDER BY Name' );
	}

	return $stmt->fetchAll();
}

/** Détail d'un pays par son id. */
function geoworld_get_country( $id ) {
	$pdo = geoworld_db();
	if ( is_wp_error( $pdo ) ) {
		return $pdo;
	}

	$stmt = $pdo->prepare( 'SELECT * FROM country WHERE id = :id' );
	$stmt->execute( array( ':id' => $id ) );
	return $stmt->fetch();
}

/** Villes d'un pays. */
function geoworld_get_cities( $country_id ) {
	$pdo = geoworld_db();
	if ( is_wp_error( $pdo ) ) {
		return $pdo;
	}

	$stmt = $pdo->prepare( 'SELECT Name, District, Population FROM city WHERE idCountry = :id ORDER BY Population DESC' );
	$stmt->execute( array( ':id' => $country_id ) );
	return $stmt->fetchAll();
}

/** Langues d'un pays — un seul JOIN au lieu d'une requête par langue. */
function geoworld_get_languages( $country_id ) {
	$pdo = geoworld_db();
	if ( is_wp_error( $pdo ) ) {
		return $pdo;
	}

	$sql = 'SELECT l.Name AS language, cl.IsOfficial, cl.Percentage
	        FROM countrylanguage cl
	        JOIN language l ON l.id = cl.idLanguage
	        WHERE cl.idCountry = :id
	        ORDER BY cl.Percentage DESC';
	$stmt = $pdo->prepare( $sql );
	$stmt->execute( array( ':id' => $country_id ) );
	return $stmt->fetchAll();
}

/*
 * --------------------------------------------------------------------------
 *  SHORTCODE [geoworld]
 * --------------------------------------------------------------------------
 */
add_shortcode( 'geoworld', 'geoworld_shortcode' );

function geoworld_shortcode( $atts ) {
	$atts = shortcode_atts(
		array( 'continent' => '' ),
		$atts,
		'geoworld'
	);

	geoworld_print_styles();

	// Vue détail si ?gw_country=ID est présent dans l'URL.
	$country_id = isset( $_GET['gw_country'] ) ? absint( $_GET['gw_country'] ) : 0;
	if ( $country_id > 0 ) {
		return geoworld_render_country( $country_id );
	}

	// Sinon : grille. Le continent peut venir de l'URL ou de l'attribut.
	$continent = $atts['continent'];
	if ( isset( $_GET['gw_continent'] ) ) {
		$continent = sanitize_text_field( wp_unslash( $_GET['gw_continent'] ) );
	}
	$continent = geoworld_valid_continent( $continent );

	return geoworld_render_grid( $continent );
}

/** N'autorise que des continents connus (évite toute valeur arbitraire). */
function geoworld_valid_continent( $continent ) {
	$allowed = array( 'Africa', 'Antarctica', 'Asia', 'Europe', 'North America', 'Oceania', 'South America' );
	return in_array( $continent, $allowed, true ) ? $continent : '';
}

/*
 * --------------------------------------------------------------------------
 *  RENDU (toutes les sorties sont échappées)
 * --------------------------------------------------------------------------
 */

/** Grille des pays. */
function geoworld_render_grid( $continent ) {
	$countries = geoworld_get_countries( $continent );

	if ( is_wp_error( $countries ) ) {
		return '<div class="gw-app"><p class="gw-error">' . esc_html( $countries->get_error_message() ) . '</p></div>';
	}

	$title = $continent
		? sprintf( __( 'Pays de %s', 'geoworld' ), $continent )
		: __( 'Tous les pays', 'geoworld' );

	ob_start();
	?>
	<div class="gw-app">
		<h2 class="gw-title"><?php echo esc_html( $title ); ?></h2>

		<div class="gw-grid">
			<?php foreach ( $countries as $country ) : ?>
				<?php
				$flag = $country->Code2
					? 'https://flagcdn.com/w320/' . strtolower( $country->Code2 ) . '.png'
					: '';
				$url  = esc_url( add_query_arg( 'gw_country', (int) $country->id ) );
				?>
				<a class="gw-card" href="<?php echo $url; ?>">
					<?php if ( $flag ) : ?>
						<img class="gw-card__flag" src="<?php echo esc_url( $flag ); ?>"
							alt="<?php echo esc_attr( sprintf( __( 'Drapeau : %s', 'geoworld' ), $country->Name ) ); ?>"
							loading="lazy" width="320" height="213">
					<?php endif; ?>
					<span class="gw-card__name"><?php echo esc_html( $country->Name ); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

/** Page détail d'un pays. */
function geoworld_render_country( $id ) {
	$country = geoworld_get_country( $id );

	if ( is_wp_error( $country ) ) {
		return '<div class="gw-app"><p class="gw-error">' . esc_html( $country->get_error_message() ) . '</p></div>';
	}
	if ( ! $country ) {
		return '<div class="gw-app"><p class="gw-error">' . esc_html__( 'Pays introuvable.', 'geoworld' ) . '</p></div>';
	}

	$cities    = geoworld_get_cities( $id );
	$languages = geoworld_get_languages( $id );
	$back_url  = esc_url( remove_query_arg( 'gw_country' ) );
	$flag      = $country->Code2 ? 'https://flagcdn.com/w320/' . strtolower( $country->Code2 ) . '.png' : '';

	// Champs "fiche" affichés proprement.
	$facts = array(
		__( 'Capitale', 'geoworld' )         => $country->Capital,
		__( 'Continent', 'geoworld' )        => $country->Continent,
		__( 'Région', 'geoworld' )           => $country->Region,
		__( 'Superficie (km²)', 'geoworld' ) => $country->SurfaceArea,
		__( 'Population', 'geoworld' )        => number_format_i18n( (int) $country->Population ),
		__( 'Indépendance', 'geoworld' )      => $country->IndepYear,
		__( 'Espérance de vie', 'geoworld' )  => $country->LifeExpectancy,
		__( 'PNB', 'geoworld' )               => $country->GNP,
		__( "Forme de gouvernement", 'geoworld' ) => $country->GovernmentForm,
		__( "Chef de l'État", 'geoworld' )    => $country->HeadOfState,
		__( 'Nom local', 'geoworld' )         => $country->LocalName,
	);

	ob_start();
	?>
	<div class="gw-app">
		<a class="gw-back" href="<?php echo $back_url; ?>">&larr; <?php esc_html_e( 'Retour', 'geoworld' ); ?></a>

		<header class="gw-head">
			<?php if ( $flag ) : ?>
				<img class="gw-head__flag" src="<?php echo esc_url( $flag ); ?>"
					alt="<?php echo esc_attr( sprintf( __( 'Drapeau : %s', 'geoworld' ), $country->Name ) ); ?>"
					width="320" height="213">
			<?php endif; ?>
			<h2 class="gw-title"><?php echo esc_html( $country->Name ); ?></h2>
		</header>

		<dl class="gw-facts">
			<?php foreach ( $facts as $label => $value ) : ?>
				<?php if ( '' !== trim( (string) $value ) && '0' !== (string) $value ) : ?>
					<div class="gw-facts__row">
						<dt><?php echo esc_html( $label ); ?></dt>
						<dd><?php echo esc_html( $value ); ?></dd>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</dl>

		<?php if ( ! is_wp_error( $cities ) && $cities ) : ?>
			<h3 class="gw-subtitle"><?php printf( esc_html__( 'Villes de %s', 'geoworld' ), esc_html( $country->Name ) ); ?></h3>
			<div class="gw-table-wrap">
				<table class="gw-table">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Ville', 'geoworld' ); ?></th>
							<th><?php esc_html_e( 'District', 'geoworld' ); ?></th>
							<th><?php esc_html_e( 'Population', 'geoworld' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $cities as $city ) : ?>
							<tr>
								<td><?php echo esc_html( $city->Name ); ?></td>
								<td><?php echo esc_html( $city->District ); ?></td>
								<td><?php echo esc_html( number_format_i18n( (int) $city->Population ) ); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>

		<?php if ( ! is_wp_error( $languages ) && $languages ) : ?>
			<h3 class="gw-subtitle">
				<?php
				printf(
					esc_html__( 'Langues de %1$s (%2$d)', 'geoworld' ),
					esc_html( $country->Name ),
					count( $languages )
				);
				?>
			</h3>
			<div class="gw-table-wrap">
				<table class="gw-table">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Langue', 'geoworld' ); ?></th>
							<th><?php esc_html_e( 'Officielle', 'geoworld' ); ?></th>
							<th><?php esc_html_e( 'Pourcentage', 'geoworld' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $languages as $lang ) : ?>
							<tr>
								<td><?php echo esc_html( $lang->language ); ?></td>
								<td><?php echo 'T' === $lang->IsOfficial ? esc_html__( 'Oui', 'geoworld' ) : esc_html__( 'Non', 'geoworld' ); ?></td>
								<td><?php echo esc_html( $lang->Percentage ); ?>&nbsp;%</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}

/*
 * --------------------------------------------------------------------------
 *  STYLES (scopés sous .gw-app — n'affectent jamais le reste du thème)
 * --------------------------------------------------------------------------
 */
function geoworld_print_styles() {
	static $done = false;
	if ( $done ) {
		return;
	}
	$done = true;
	?>
	<style>
		.gw-app {
			--gw-accent: #182357;
			--gw-border: #e3e6f0;
			--gw-radius: 12px;
			max-width: 1100px;
			margin-inline: auto;
			color: inherit;
		}
		.gw-title { font-size: clamp(1.6rem, 4vw, 2.5rem); margin: 0 0 1.25rem; }
		.gw-subtitle { font-size: clamp(1.2rem, 3vw, 1.6rem); margin: 2rem 0 .75rem; }

		.gw-grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
			gap: 1rem;
		}
		.gw-card {
			display: flex;
			flex-direction: column;
			border: 1px solid var(--gw-border);
			border-radius: var(--gw-radius);
			overflow: hidden;
			text-decoration: none;
			color: inherit;
			background: #fff;
			transition: transform .15s ease, box-shadow .15s ease;
		}
		.gw-card:hover,
		.gw-card:focus-visible {
			transform: translateY(-4px);
			box-shadow: 0 8px 24px rgba(24, 35, 87, .18);
		}
		.gw-card__flag { width: 100%; height: auto; aspect-ratio: 3 / 2; object-fit: cover; display: block; }
		.gw-card__name { padding: .6rem .75rem; font-weight: 600; }

		.gw-back { display: inline-block; margin-bottom: 1rem; text-decoration: none; font-weight: 600; }

		.gw-head { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
		.gw-head__flag { width: 96px; height: auto; border-radius: 6px; border: 1px solid var(--gw-border); }

		.gw-facts {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
			gap: .5rem 1.5rem;
			margin: 1.5rem 0;
		}
		.gw-facts__row { display: flex; justify-content: space-between; gap: 1rem; border-bottom: 1px dashed var(--gw-border); padding: .35rem 0; }
		.gw-facts dt { font-weight: 600; }
		.gw-facts dd { margin: 0; text-align: right; }

		.gw-table-wrap { overflow-x: auto; }
		.gw-table { width: 100%; border-collapse: collapse; }
		.gw-table th, .gw-table td { padding: .55rem .75rem; text-align: left; border-bottom: 1px solid var(--gw-border); }
		.gw-table th { background: var(--gw-accent); color: #fff; position: sticky; top: 0; }
		.gw-table tbody tr:nth-child(even) { background: rgba(24, 35, 87, .04); }

		.gw-error { padding: 1rem; border-radius: var(--gw-radius); background: #fdecec; color: #9b1c1c; }
	</style>
	<?php
}
