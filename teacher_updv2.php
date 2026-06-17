<?php 
require_once('inc/functions.php');
require_once 'inc/manager-db.php';
require_once 'header.php'; ?>

<h1>M.A.J</h1>
<div class="box shadow p-3">
        <div class="ribbon"><span><?php echo $_SESSION['role'];?></span></div>
    <p>here you can update the data </p>
</div>
<br>

<section class="">
      <div class="container">
      <form action="inc/update.php" method="post">
      <?php $tables = getTables();?>
      <div class="row">
            <div class="col-lg-3">
            UPDATE <select name="table" id="table" onchange="getColumns(this.value)"><?php echo buildOptionForTables($tables);?></select> 
            </div>
              <hr/>                          
      
      <div class="col-lg-12 table-fixed" id="data">
            
        </div>
      
      <div class="col-lg-12" id="upd">
                  
            </div>
            <div class="col-lg-12">
            <style>#update,#cancel{
                display:none}</style><div class="row">
                  <div class="col"><input style-display="none"  type="submit" class="form-control btn btn-success" value="Update" id="update"></div>
                 <div class="col"> <input style-display="none" type="button" class="form-control btn btn-danger" onClick="canceLine()" value="Cancel" id="cancel"></div>
            </div>
      </div>  
      </div>


</form>
</div>
</section>

<?php
require_once 'javascripts.php';
require_once 'footer.php';
?>