<?php 
require_once('inc/functions.php');
require_once 'inc/manager-db.php';
require_once 'header.php'; ?>

<?php
if(isset($_GET['updated'])){
  $up = intval($_GET['updated']);
  if ($up){
  echo "<div class=\"alert alert-success\" id=\"success\">updated 
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
  <span aria-hidden=\"true\">&times;</span>
</button></div>";
  }
    else {
      echo "<div class=\"alert alert-danger\" id=\"fail\">not updated
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
  <span aria-hidden=\"true\">&times;</span>
</button></div>";
    }
}
$info = getInfoAcount($_SESSION['id']);
$id=$_SESSION['id'];
$role = $_SESSION['role'];?>

<h1>Informations of the Account</h1>

      <div class="box shadow p-3">
            <div class="ribbon red"><span><?php echo $_SESSION['role']; ?></span></div>
            <p>here you can view your account information</p>
      </div>
      <br>
      
      <section class="">
            <div class="row">
            <div class="container col-lg-8 text-center" id="tbl" style="padding-top:2em">
                  <?php echo buildInfoTable($info,$role);?>
                  </div>
                  <div class="col-lg-12 text-center alert alert-info" id="rep" style="display:none; margin-top:2em">

                  </div>
                  <div class="col-lg-8 " >
                  <form action="Inc/edit.php" method="post" id="form" style="display:none" >
                        
                  </form>
                  
                  </div>
                  <input type="button" value="Go Back" onClick="goBack()" class="btn btn-dark" style="display:grid; justify-content:center; align-items:center;">
            </div>
      </section>


<?php
require_once 'javascripts.php';
require_once 'footer.php';
?>