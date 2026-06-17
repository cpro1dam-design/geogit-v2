<?php 
require_once('functions.php');
require_once 'manager-db.php';
?>


<?php

$id=$_GET['id'];
$role=$_GET['role'];
$user=getInfoAcount($id);
//var_dump($user);
 $form = buildFormModif($user,$role);
 echo $form;?>