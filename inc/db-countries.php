<?php
/**
 * Accès aux données — Pays, villes et langues.
 * (Fonctions extraites de manager-db.php — comportement inchangé.)
 */

/** Obtenir la liste de tous les pays référencés d'un continent donné
 * @param $continent le nom d'un continent
 * @return tableau d'objets (des pays)
 */
function getCountriesByContinent($continent)
{
  // pour utiliser la variable globale dans la fonction
  global $pdo;
  $query = 'SELECT * FROM country WHERE Continent = :continent ORDER BY Name;';
  $prep = $pdo->prepare($query);
  $prep->bindValue(':continent', $continent, PDO::PARAM_STR);
  $prep->execute();
  // var_dump($prep);
  // var_dump($continent);
  return $prep->fetchAll();
}

/** Obtenir la liste des pays
 * @return liste d'objets
 */
function getAllCountries()
{
  global $pdo;
  $query = 'SELECT * FROM country ORDER BY Name;';
  return $pdo->query($query)->fetchAll();
}


function getCountryByID($id)
{
  global $pdo;
  $sql = 'SELECT * FROM country WHERE id=?;';
  $query = $pdo->prepare($sql);
  $query->execute([$id]);
  return $query->fetch();
}


function getCountryByName($name)
{
  global $pdo;
  $sql = 'SELECT * FROM country WHERE Name LIKE ? ORDER BY Name;';
  $query = $pdo->prepare($sql);
  $query->execute(["$name%"]);
  return $query->fetchAll();
}

 function getCity($idCountry){
   global $pdo;
   $sql="SELECT * FROM city where idCountry = ? ;";
   $query = $pdo->prepare($sql);
   $query->execute([$idCountry]);
   return  $row = $query->fetchAll();
 }

 function getCountryLanguage($idCountry){
  global $pdo;
  $sql="SELECT * FROM countrylanguage where idCountry = ? ;";
  $query = $pdo->prepare($sql);
  $query->execute([$idCountry]);
  return $row = $query->fetchAll();
}


function getLanguage($id){
  global $pdo;
  $sql="SELECT * FROM language where id = ? ;";
  $query = $pdo->prepare($sql);
  $query->execute([$id]);
  $row = $query->fetch();
  return $row ? $row->Name : '';
}
