<?php require_once 'manager-db.php';
session_start();
$del_id = $_GET['del_id'];
echo $del_id;
var_dump('location: ../'.$_SESSION['role'].'.php');
deleteUser($del_id);
header('location: ../'.$_SESSION['role'].'.php');