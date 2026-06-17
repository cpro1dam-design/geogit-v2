<?php require_once 'manager-db.php';
require_once 'functions.php';
$id = $_GET['id'];

$table = $_GET['table'];
$row = dataColumn($id,$table);

echo buildForm($row,$table);?>


