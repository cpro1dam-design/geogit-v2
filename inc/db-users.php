<?php
/**
 * Accès aux données — Utilisateurs / comptes.
 * (Fonctions extraites de manager-db.php — comportement inchangé.)
 */

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

   function getNameUser($id_user){
    global $pdo;
    $sql="SELECT name FROM users WHERE id = ?;";
    $qry = $pdo->prepare($sql);
    $qry->execute([$id_user]);
    return $row = $qry->fetch();
   }
