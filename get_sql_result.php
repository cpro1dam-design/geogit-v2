<?php
require_once('inc/functions.php');
require_once 'inc/manager-db.php';

$sql= $_POST['sql'];
$qry = $pdo->prepare($sql);
$qry->execute();
$rows = $qry->fetchAll();

// var_dump($rows);
echo buildTable($rows);