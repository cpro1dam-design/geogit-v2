<?php
require_once('inc/functions.php');
require_once 'inc/manager-db.php';
$column = $_GET['column'];
$table = $_GET['table'];

$row = getColumnData($column ,$table);
var_dump($rows);

echo buildTable($rows);
var_dump($rows);
