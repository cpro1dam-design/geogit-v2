<?php
/**
 * Accès aux données — Schéma & requêtes génériques (tables, colonnes…).
 * (Fonctions extraites de manager-db.php — comportement inchangé.)
 */

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
