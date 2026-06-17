<?php 
require_once('functions.php');
require_once 'manager-db.php';
$name= $_POST['name'];
$fname= $_POST['firstname'];
$mail= $_POST['mail'];
$pass = $_POST['password'];
$id = intval($_POST['id']);

$user = getInfoAcount($id);

$originalUser = [
    $user->name,
    $user->firstname,
    $user->mail
];

$newUser = [
    $name,
    $fname,
    $mail
];

$originalUserHash = md5(implode('/', $originalUser));
$newUserHash = md5(implode('/', $newUser));

if ($originalUserHash != $newUserHash || ($pass != "********" && $pass != $user->password)) {
    if ($pass != "********" && $pass != $user->password) { // password changes
        updateData($id, $name,$fname,$mail, $pass);
    } else {
        updateData($id, $name,$fname,$mail);
    }

    header("location: ../infoAccount.php?id=$id&updated=1"); 
} else {
    header("location: ../infoAccount.php?id=$id&updated=0"); 
}



