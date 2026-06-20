<?php
/**
 * Authentification.
 * (Fonction extraite de functions.php — comportement inchangé.)
 */

function isAuth() {
    return isset($_SESSION['nom']);
}
