<?php 
require_once('inc/functions.php');
require_once 'inc/manager-db.php';
require_once 'header.php'; ?>

<h1>UPDATE</h1>
<div class="box shadow p-3">
        <div class="ribbon"><span><?php echo $_SESSION['role'];?></span></div>
    <p>here you can choose your update method </p>
</div>
<br>

<div class="row">

<div class="col">
<div class="card" style="width: 25rem;"> 
<a href="files_upd.php">
  <img class="card-img-top" src="images/card/files.jpg" alt="Card image cap">
  <div class="card-body">
    </a><p class="card-text">here you can update the database with sql files</p>
  </div>
</div>
</div>

<div class="col">
<div class="card" style="width: 24rem;"> 
<a href="teacher_updv2.php">
  <img class="card-img-top" src="images/card/manualy.jpg" alt="Card image cap">
  <div class="card-body">
    </a><p class="card-text">here you can update the database manualy</p>
  </div>

</div>
</div>

</div>



<?php
require_once 'javascripts.php';
require_once 'footer.php';
?>