<?php 
require_once('inc/functions.php');
require_once 'inc/manager-db.php';
require_once 'header.php'; ?>

<main role="main" class="flex-shrink-0 flex-grow-1">

  <div class="container">
  <?php $acceuil="acceuil"; if (isset($_GET['reg'])){
    $msg=$_GET['reG'];
    if($msg == 0){
      echo "<span class =\"red\">user registered</span>";
     }elseif ($msg == 1) {
      echo"<span class =\"red\">mail already registered</span>";
     } 
     else {

      }
    
  }
      
     if (!isset($_GET["continent"])) { ?>
    <h1>All countries</h1>
    <?php } else { ?>
    <h1>The countries of <?php $pays=$_GET["continent"]; echo $pays;  ?></h1>
    <?php } ?>
    <div>
        <?php
            

            //$continent = 'Asia';
            //$desPays = getAllCountries();
            
            //$continent = $_POST["continents"];*/
 
            if (isset($_GET["continent"])){
              $continent=$_GET["continent"];
              //echo "$continent";
              if (!empty($continent)) {
                  $desPays = getCountriesByContinent($continent);
              }
            } else {
              $desPays = getAllCountries();
            }

     
          $i=1;echo"<div class=\"row  g-3\" >";
          foreach ($desPays as $value) {
            
            
              echo"<div class=\"col-lg-3 col-md-4 col-6\" >";
              $flag = 'images/'.strtolower($value->Code2);
              echo "
              <div class=\"image flag-img\"><a  href='infopays.php?id={$value->id}' class=\"flag\" >
              <img class=\"image__img\" src=\"$flag.png\" alt=\"\" >
              <div class=\"image__overlay\">
              <div class=\"image__title\">{$value->Name}</a>
              </div>
              </div>
              </div> &nbsp; <br>";
              $i++;
              echo"</div>";
            
          }
          echo"</div>";
         ?>
      
    </div>
    <p></p><!--
    <section class="jumbotron text-center">
      <div class="container">
        <h1 class="jumbotron-heading">Tableau d'objets</h1>
        <p>Le code ci-dessus représente une vue "debug" du premier élément d'un tableau. Ce tableau est
          constitué d'objets PHP "standard" (stdClass).</p>
        <p>Pour accéder à l'<b>attribut</b> d'un <b>objet</b> on utilisera le symbole <code>-></code></p>
        <p>Ainsi, pour accéder au nom du premier pays de la liste
          <code>$desPays</code> on fera <b><code>$desPays[0]->Name</code></b>
        </p>
        <p>La variable <b><code>$desPays</code></b> référence un tableau (<i>array</i>).
          Ainsi, pour générer le code HTML (table), devriez vous coder une boucle,
          par exemple de type <b><code>foreach</code></b> sur l'ensembles des objets de ce tableau. </p>
        <p>Référez-vous à la structure des tables pour connaître le nom des <b><code>attributs</code></b>.
          En effet, les objets du tableau ont pour attributs (nom et valeur)
          le nom des colonnes de la table interrogée par un requête SQL, via l'appel à la
          fonction <b><code>getCountriesByContinent</code></b> (du script <b><code>manager-db.php</code></b>.</p>
        <p>Par exemple <b><code>Name</code></b> est une des colonnes de la relation (table) <b><code>Country</code></b>)</p>

      </div>
    </section> -->
  </div>
</main>

<?php
require_once 'javascripts.php';
require_once 'footer.php';
?>
