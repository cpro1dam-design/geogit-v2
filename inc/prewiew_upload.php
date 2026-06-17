<?php 
require_once('functions.php');
require_once 'manager-db.php';

//var_dump($_POST, $_FILES); die();

if (isset($_FILES['upload'])) {
    
    //echo "info files<br>";
    $files = $_FILES['upload'];
    if ($files['error'] === 0) {
        /* foreach ($files as $key => $value) {
        echo $key ."=". $value ."<br>";
    } */
    $up_txt=file_get_contents($files['tmp_name']);
    //var_dump($up_txt);
    echo $up_txt;
    }
   
    
}