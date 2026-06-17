<?php 
require_once('inc/functions.php');
require_once 'inc/manager-db.php';
?>


<?php

$id=$_GET['id'];
$role=$_GET['role'];
$user=getInfoAcount($id);
//var_dump($user);
 echo  buildFormModif($user,$role);?>
  
    

