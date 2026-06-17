<?php 
require_once('functions.php');
require_once 'manager-db.php';


$req = $_POST['testsql'];
$tab = testSql($req);
var_dump($tab);