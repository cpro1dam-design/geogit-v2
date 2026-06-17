<?php
require_once('inc/functions.php');
require_once 'inc/manager-db.php';
$table = $_GET['table'];
/*$sql= "SHOW columns FROM $table";
$qry = $pdo->prepare($sql);
$qry->execute();
$rows = $qry->fetchAll();

// var_dump($rows);
echo buildOptionForColumns($rows);

*/$row_col = getColumnData($table);
//var_dump($row_col);

echo buildTableNoId($row_col,$table);