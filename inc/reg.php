

<?php 
require_once('functions.php');
require_once 'manager-db.php';
 ?>

<?php
$nam=$_POST["name"];
$fname=$_POST["firstname"];
$email=$_POST["ID"];
$password=$_POST["mdp"];

global $pdo;
$sql="SELECT count(*) FROM users where mail = ?";
$qry = $pdo->prepare($sql);
$qry->execute([$email]);
$exists = $qry ->fetchColumn();

var_dump($exists);

if (!$exists) {
     $sql = "INSERT INTO users (name,firstname,mail,password) VALUES (?, ?, ?, ?)";
    $qry = $pdo->prepare($sql);
    $success = $qry->execute([$nam, $fname, $email, $password]);
           header('location: ../index.php?reg=O?');
}else {
    header('location: ../index.php?reg=1');
 }




/*$sql = "INSERT INTO users (name,firstname,mail,password) VALUES (?, ?, ?, ?)";
$qry = $pdo->prepare($sql);
$success = $qry->execute([$nam, $fname, $email, $password]);

if ($success) {
    header('location index.php');
   
} else {
       echo 'mail deja enregistrer <br> <a href="register.php">Go back</a>';
    }
*/
?>