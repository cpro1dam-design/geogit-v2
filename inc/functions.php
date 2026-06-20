<?php
/**
 * Fonctions partagées (agrégateur).
 *
 * Le contenu historique a été réparti par type dans des fichiers dédiés :
 *   - auth.php   : authentification (isAuth…)
 *   - render.php : génération du HTML (tables, formulaires, options…)
 *
 * Ce fichier conserve l'API d'origine : tout script qui faisait
 * `require_once 'inc/functions.php'` charge toujours l'ensemble des
 * fonctions, exactement comme avant.
 */
require_once 'auth.php';
require_once 'render.php';
