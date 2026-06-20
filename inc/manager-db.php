<?php
/**
 * Couche d'accès aux données (agrégateur).
 *
 * Les fonctions sont désormais centralisées par type dans des fichiers
 * dédiés. Ce fichier conserve l'API historique : tout script qui faisait
 * `require_once 'inc/manager-db.php'` continue d'obtenir l'ensemble des
 * fonctions de la base de données, comme avant.
 *
 *   - db-countries.php : pays, villes, langues
 *   - db-users.php     : utilisateurs / comptes
 *   - db-queries.php   : requêtes enregistrées (table « query »)
 *   - db-schema.php    : schéma & requêtes génériques
 */
require_once 'connect-db.php';
require_once 'db-countries.php';
require_once 'db-users.php';
require_once 'db-queries.php';
require_once 'db-schema.php';
