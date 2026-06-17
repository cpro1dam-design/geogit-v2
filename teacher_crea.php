<?php 
require_once('inc/functions.php');
require_once 'inc/manager-db.php';
require_once 'header.php'; ?>


<h1>The development of queries</h1>
<div class="box shadow p-3">
      <div class="ribbon red"><span><?php echo $_SESSION['role']; ?></span></div>
<p>it is a space where the teacher create SQL queries</p>
      </div>
      <br>


      <div class="row " style="margin:10px">
            <div class="col-lg-6 " >
            
            <form action="inc/crea_req.php" method="post">

            <div class="form-group">
            <label for="name">Name of the Query</label>
            <br>
            <input type="text" name="name" class="form-control">
            <br>
            <label for="statut">Statut</label>
            <select name="statut" id="st" class="form-control">
            <option value="private">private</option>

            <option value="public">public</option>
            </select>
            <br></div>
            
            <label for="data">Query</label>
            <br>
            <textarea class="form-control" cols="64" rows="8" placeholder="SELECT..." name="data" id="sql"></textarea>
            <br>           

<div class="row">
      <div class="col"><input type="submit" value="Save" class="form-control btn btn-outline-light" >
</div>
      <div class="col"><input type="button" value="Test" class="form-control btn btn-dark" onClick="tst_reqPers()">
</div>


</div></form>     
</div>      
            
            <div class="testz col-lg-6 jumbotron text-center table-fixed " style="padding:1em;">
            <h1 class="jumbotron heading">Zone de test</h1>
            <div id="sql-result">
                  
            </div>
            <input style="display :none" class="btn btn-danger"  type="button" onClick="cancelReqCrea()" value="Cancel" id="cancel">
            </div>
      </div>




<?php
require_once 'javascripts.php';
require_once 'footer.php';
?>
