<?php  
require_once('inc/functions.php');
require_once 'header.php'; 
require_once 'inc/manager-db.php';
$search = $_GET['rechercher']; ?>

<main role="main" class="flex-shrink-0">
  <div class="container">

<?php
//var_dump(getCountryByID(10));
//var_dump(getCountryByName($search));

$desPays = getCountryByName($search);

if (count($desPays) > 0){
    echo count($desPays)." résultat(s) pour ".$search.'<hr>'; 
    $i=1;
    foreach ($desPays as $value) {
      $flag = 'images/'.strtolower($value->Code2);
      echo "  <img src=\"$flag.png\" alt=\"\" width=\"64\" heigth=\"32\" class=\"border\"> <a href='infopays.php?id={$value->id}'>{$value->Name}</a> &nbsp; <br>";
      $i++;
    }
} else {
    echo "Aucun résultat trouvé";
}
?>

</div>
</main>



<?php
require_once 'javascripts.php';
require_once 'footer.php';
?>