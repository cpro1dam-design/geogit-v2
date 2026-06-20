<?php
/**
 * Accès aux données — Requêtes enregistrées (table « query »).
 * (Fonctions extraites de manager-db.php — comportement inchangé.)
 */

 function addQuery($id,$name,$data,$statut){
   global $pdo;
$sql="INSERT INTO query (id_user,query_name,query_data,query_statut) VALUES (?, ?, ?,?)";
$qry = $pdo->prepare($sql);
$req = $qry->execute([$id,$name,$data,$statut]);
 }

function QueryById($id){
  global $pdo;
  $sql="SELECT * FROM query WHERE id_user = ?;";
  $qry = $pdo->prepare($sql);
  $qry->execute([$id]);
  return $row = $qry->fetchAll();
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
