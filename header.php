<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <!--<title>Homepage : Bootstrap 4</title>-->
  <title>GeoWorld</title>
  <!-- Bootstrap core CSS -->
  <link href="assets/bootstrap-4.2.1-dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 <!--<link rel="shortcut icon" href="images/favicon/favicon-16x16.png" type="image/png">-->
 <link rel="shortcut icon" href="images/icons8-globe.gif" type="image/gif">
  <!-- Custom styles for this template -->
  <link href="css/custom.css" rel="stylesheet">
  <style>
    

  .main-form{
  width: 450px;
  margin:auto;
}
  

    .table-select:hover {
      cursor: pointer;
      background-color: #0131b4 ; 
    } 
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
</head>
<?php 
require_once('inc/functions.php');
session_start()?>
<body class="d-flex flex-column min-vh-100 bg-<?php if(isset($_GET['continent'])){$continent=$_GET['continent'];
$conversion = array(" "=>"");
$continent= strtr($continent,$conversion);
echo  $continent;}else {
  if (!isset($accuei)) {
    echo "study";
  }
}?>">
<div class="planet planetEarth">
        <h2>Geoworld</h2>
        <div class="contain">
            <div class="loader"><span></span></div>
            <div class="earth"></div>
        </div>
    </div>
<header>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="Geoloader.html">GeoWorld</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <!--<li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>-->

        <?php if (isAuth()) { ?>
          <li class="nav-item">
          <a class="nav-link disabled" href="#"><?php echo $_SESSION['nom']; ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="inc/log_out.php">Logout</a>
        </li>
        <?php } else { ?>
        <li class="nav-item">
          <a class="nav-link disabled" href="#">Disconnected</a>
        </li>        
        <?php } ?>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
             aria-expanded="false">Select Continent</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01" name="continents">
            <a class="dropdown-item" href="index.php?continent=Asia"  >Asia</a>
            <a class="dropdown-item" href="index.php?continent=Africa" >Africa</a>
            <a class="dropdown-item" href="index.php?continent=South America" >South America</a>
            <a class="dropdown-item" href="index.php?continent=North America" >North America</a>
            <a class="dropdown-item" href="index.php?continent=Oceania" >Oceania</a>
            <a class="dropdown-item" href="index.php?continent=Europe" >Europe</a>
            <a class="dropdown-item" href="index.php?continent=Antarctica" >Antarctica</a>
            

          </div>
        </li>
      </ul>
      
      <ul class="navbar-nav ml-auto">
      <?php if (isAuth()) { ?>
          <li class="nav-item">
          <a class="nav-link " href="infoAccount.php"><?php echo "infoAcount"; ?></a>
        </li>
    
        <?php } else { ?>
          <li class="nav-item">
          <a class="nav-link" href='login.php'>
               Login
              </a>
        </li>    
        <?php } ?>

        <?php if (isAuth() ) { 
          if($_SESSION['role'] == "teacher"){?> 
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown02" data-toggle="dropdown" aria-haspopup="true"
             aria-expanded="false">Teacher Gestion</a>
          <div class="dropdown-menu" aria-labelledby="dropdown02" name="teacher">
            <a class="dropdown-item" href="teacher_crea.php"  >Create request</a>
            <a class="dropdown-item" href="teacher_mana.php" >manage your requests</a>
            <a class="dropdown-item" href="update_menu.php" >Update</a>
          <?php } 
        else{?>
          <li class="nav-item">
          <a class="nav-link " href="<?php echo $_SESSION['role']; ?>.php"><?php echo $_SESSION['role']; ?></a>
        
        </li>  
        
            
        <?php }
        } ?>
        <li class="nav-item">
          <?php if (!isset ($_SESSION['role'])){
            echo '<a class="nav-link" href="register.php">Register</a>';
          }?>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="todo-projet.php">
            ProjetPPE-SLAM
          </a>
        </li>
       
      </ul>
     <form class="form-inline my-2 my-lg-0" action="search.php" method="get">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text bg-white border-right:0" >
                <i class="fa-solid fa-magnifying-glass text-muted"></i>
            </span>
        </div>

        <select name="rechercher" id="search" 
                class="form-control border-left-0 custom-select-search" 
                onchange="if(this.value) location.href='infopays.php?id=' + this.value">
            
            <option value="" selected disabled>Search for a country...</option>
            
            <optgroup label="Asia">
                <?php echo buildOptionForCont("Asia"); ?>
            </optgroup>
            <optgroup label="Africa">
                <?php echo buildOptionForCont("Africa"); ?>
            </optgroup>
            <optgroup label="North America">
                <?php echo buildOptionForCont("North America"); ?>
            </optgroup>
            <optgroup label="South America">
                <?php echo buildOptionForCont("South America"); ?>
            </optgroup>
            <optgroup label="Europe">
                <?php echo buildOptionForCont("Europe"); ?>
            </optgroup>
            <optgroup label="Oceania">
                <?php echo buildOptionForCont("Oceania"); ?>
            </optgroup>
            <optgroup label="Antarctica">
                <?php echo buildOptionForCont("Antarctica"); ?>
            </optgroup>
        </select>
    </div>
    
    <button class="btn btn-outline-light d-none d-md-inline-block ml-2" type="submit" >
        Go
    </button>
</form>
    </div>
  </nav>
</header>

