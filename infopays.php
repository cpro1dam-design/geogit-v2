<?php  
require_once('inc/functions.php');
require_once 'inc/manager-db.php';
require_once 'header.php'; ?>

<main role="main" class="flex-shrink-0">

  <div class="container">
    
    <div>
        <?php
            
            //$continent = 'Asia';
            //$desPays = getAllCountries();
            $id = $_GET['id'];
            $pays = getCountryByID($id);
            $city = getCity($id);
            $C_language = getCountryLanguage($id);

          
     ?>
    <h1><?php echo $pays->Name;
    echo '<img src="images/'.strtolower($pays->Code2).'.png" alt="" width="128" heigth="64" class="border">';?></h1>
      <div class="container" style="overflow-x:auto" >
        <table class="table">
        <thead>
          <tr>
       <th>Code</th>
       <th>Name</th>
       <th>Continent</th>
       <th>Region</th>
       <th>SurfaceArea</th>
       <th>IndepYear</th>
       <th>Population</th>
       <th>LifeExpectancy</th>
       <th>GNP</th>
       <th>GNPOld</th>
       <th>LocalName</th>
       <th>GovernemmentForm</th>
       <th>HeadOfState</th>
       <th>Capital</th>
       <th>Code2</th>
       </tr>
       </thead>
       <tbody>
         <?php //var_dump($city);
         //echo "<br>";
         //var_dump($C_language);
          echo  "<tr><td>".$pays->Code."</td>
              <td>".$pays->Name."</td>
              <td>".$pays->Continent."</td>
              <td>".$pays->Region."</td>
              <td>".$pays->SurfaceArea."</td>
              <td>".$pays->IndepYear."</td>
              <td>".$pays->Population."</td>
              <td>".$pays->LifeExpectancy."</td>
              <td>".$pays->GNP."</td>
              <td>".$pays->GNPOld."</td>
              <td>".$pays->LocalName."</td>
              <td>".$pays->GovernmentForm."</td>
              <td>".$pays->HeadOfState."</td>
              <td>".$pays->Capital."</td>
              <td>".$pays->Code2."</td></tr>";
          echo"</tbody></table>";
        
         ?></div> 
         <h3>City of <?php echo $pays->Name;?></h3>
         <div class="container table-fixed" >
         <table class="table ">
         
        <thead>
          <tr>
       <th>name </th>
       <th>district </th>
       <th>population</th>
       </tr>
       </thead>
       <tbody>
         <?php $i=0;
         foreach ($city as $value) {
          echo "<tr><td>".$value->Name."</td>
          <td>".$value->District."</td>
          <td>".$value->Population."</td>
          </tr>";
          $i++;
         } 
          echo"</tbody></table>";
        
         ?>
         </div>
         
        <h3>Language of <?php echo $pays->Name;?>
        <?php echo "  Number of spoken language : ".count ($C_language); ?></h3>
        <div class="table-fixed">
         <table class="table">
        <thead>
          <tr>
       <th>language </th>
       <th>Official language</th>
       <th>percent of</th>
       </tr>
       </thead>
       <tbody>
         <?php $i=0;
         foreach ($C_language as $value) {
          echo "<tr><td>".getLanguage($value->idLanguage)."</td>
          <td>".  ($value->IsOfficial == 'T' ? "YES" : "NO") ."</td>
          <td>".  $value->Percentage ."%</td>
          </tr>";
          $i++;
         } 
          echo"</tbody></table>";
          
         ?></div>
         <input type="button" value="Go back"  class="btn-lg btn-outline-dark " onClick="goBack()">
    <!--  
    </div>
    <p></p>
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
    </section>
  </div>
</main> -->

<?php
require_once 'javascripts.php';
require_once 'footer.php';
?>
