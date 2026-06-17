<?php
require_once 'connect-db.php';

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

function connectAcount($user,$password){
global $pdo;
$sql="SELECT * FROM users WHERE mail = ? AND password =?;";
$qry = $pdo->prepare($sql);
$qry->execute([$user, $password]);
return $row = $qry->fetch();
}

function getInfoAcount($id){
  global $pdo;
  $sql="SELECT * FROM users WHERE id = ? ;";
  $qry = $pdo->prepare($sql);
  $qry->execute([$id]);
  return $row = $qry->fetch();
  }

  function getAllInfoAcount(){
    global $pdo;
    $sql="SELECT * FROM users  ;";
    $qry = $pdo->prepare($sql);
    $qry->execute();
    return $row = $qry->fetchAll();
    }


 function deleteUser($userid){
  global $pdo;
  $sql = "DELETE FROM users WHERE id = ? ;";
  $query = $pdo->prepare($sql);
  $query->execute([$userid]);
  return $query->rowCount(); 
 }

 function addQuery($id,$name,$data,$statut){
   global $pdo;
$sql="INSERT INTO query (id_user,query_name,query_data,query_statut) VALUES (?, ?, ?,?)";
$qry = $pdo->prepare($sql);
$req = $qry->execute([$id,$name,$data,$statut]);
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

function updateData($id, $name,$fname,$mail, $pass = null){
  global $pdo;
  if ($pass === null) {
    $sql= "UPDATE users SET name = ?, firstname = ?, mail = ? WHERE id = ? ;";
    $set = [$name,$fname,$mail, $id];
  } else {
    $sql= "UPDATE users SET name = ?, firstname = ?, mail = ?, password = ? WHERE id = ? ;";
    $set = [$name,$fname,$mail, $pass, $id];
  }

  $qry = $pdo->prepare($sql);
  $req = $qry->execute($set);
}

function QueryById($id){
  global $pdo;
  $sql="SELECT * FROM query WHERE id_user = ?;";
  $qry = $pdo->prepare($sql);
  $qry->execute([$id]);
  return $row = $qry->fetchAll();
   }
   function getNameUser($id_user){
    global $pdo;
    $sql="SELECT name FROM users WHERE id = ?;";
    $qry = $pdo->prepare($sql);
    $qry->execute([$id_user]);
    return $row = $qry->fetch();
   }

   function QueryByStatut(){
    global $pdo;
    $sql="SELECT * FROM query WHERE query_statut = 'public' ;";
    $qry = $pdo->prepare($sql);
    $qry->execute();
    $row = $qry->fetchAll();
    return $row;
     }

     function testSql($req){
       global $pdo;
       $sql="?";
       $qry = $pdo->prepare($sql);
       $qry->execute($req);
       $row = $qry->fetchAll();
       return $row;
     }

     function getTables(){
      global $pdo;
      $sql="SHOW tables;";
      $qry = $pdo->prepare($sql);
      $qry->execute();
      return $row = $qry->fetchAll();
     }

     function upDataDb($req){
      global $pdo;
      $sql= $req;
      $qry = $pdo->prepare($sql);
      $qry->execute();
     }

     function getColumnData($table){
       global $pdo;
      $sql="SELECT * FROM $table;";
      $qry = $pdo->prepare($sql);
      $qry->execute();
      return $row = $qry -> fetchAll();
     }

     function dataColumn($id,$table){
      global $pdo;
      if (is_array($id)) {
        $sql="SELECT * FROM $table WHERE idCountry = ? AND idLanguage = ?;";
        $qry = $pdo->prepare($sql);
        $qry->execute($id);        
      } else {
        $sql="SELECT * FROM $table WHERE id= ?;";
        $qry = $pdo->prepare($sql);
        $qry->execute([$id]);
      } 

      return $row = $qry->fetch();
       }

       function getKey($table){
        global $pdo;
        $sql="DESCRIBE $table;";
        $qry = $pdo->prepare($sql);
        $qry->execute();
        return $row = $qry->fetchAll();
       }