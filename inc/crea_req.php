<?php  
require_once('functions.php');
require_once 'manager-db.php';

session_start();


var_dump($_SESSION['id']);
$id = $_SESSION['id'];
$name =$_POST['name'];
$data = $_POST['data'];
$statut =$_POST['statut'];





addQuery($id,$name,$data,$statut);
header('location:../teacher_crea.php')

?>