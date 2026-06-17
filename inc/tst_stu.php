<?php require_once 'manager-db.php';
require_once 'functions.php';
$req = $_POST['testsql'];
var_dump($req);


    $sql= $req;
    $qry = $pdo->prepare($sql);
    $qry->execute();
    $rows = $qry->fetchAll();

    var_dump($rows);
    buildTable($rows);
  