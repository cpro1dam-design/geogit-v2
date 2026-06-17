<?php 
require_once('inc/functions.php');
require_once 'inc/manager-db.php';
require_once 'header.php'; ?>

<h1>M.A.J</h1>
<div class="box shadow p-3">
      <div class="ribbon"><span><?php echo $_SESSION['role'];?></span></div>
<p>here you can update the data </p>
      </div><br>

<section class="jumbotron text-center">
      <div class="container">
      <form action="inc/update.php" method="post">
      <?php $tables = getTables();?>
      <div class="row">
            <div class="col-lg-3">
            UPDATE <select name="table" id="table" onchange="getColumns(this.value)"><?php echo buildOptionForTables($tables);?></select> 
            </div>
            <div class="col-lg-3" id="column-div">
            SET <select name="column[]" id="column" ></select> =
            </div>
            <div class="col-lg-2" id="value-div">
            <input type="text"  name="value[]" placeholder="?">
            </div>
            <div class="col-lg-2">
            <input type="button" value="+" onClick="ajouterParam()">
            </div>                                 
      </div>
      <div class="row">
            <div class="col-lg-12">
                  <input type="submit" value="Update">
            </div>  
      </div>


</form>
</div>
</section>

<?php
require_once 'javascripts.php';
require_once 'footer.php';
?>