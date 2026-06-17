<?php 
require_once 'manager-db.php';
require_once 'connect-db.php';

$ut = $_POST['user'];
$pass = $_POST['password'];


$row = connectAcount($ut,$pass);

$name=$row->name;
$role=$row->role;
$mail=$row->mail;
$id=$row->id;


if ($row === false) {
    header('Location: ../login.php?auth=0');
} else {
session_start();

$_SESSION['nom'] = $name;
$_SESSION['role'] = $role;
$_SESSION['mail'] = $mail;
$_SESSION['id'] = $id;


    header('location: ../index.php');



}






?>