<?php 
require_once('inc/functions.php');
require_once 'inc/manager-db.php';
require_once 'header.php'; ?>
<h1>Laboratory</h1>
<div class="box shadow p-3">
      <div class="ribbon"><span><?php echo "student";?></span></div>
<p>it is a space where the student can test and create public SQL queries</p>
      </div><br>
<?php  $req = QueryByStatut();
//var_dump($req);?>




<div class="row text-center" style="padding:2em">
    <div class="col-lg-3">
        

        <textarea name="testsql" id="sql" cols="25" rows="10" placeholder="SELECT..."></textarea>
        <br>
        <input type="button" class="btn btn-success" value="Execute" onclick = "tst_reqPers()"  >
        <input type="reset" value="Delete"  class="btn btn-info"  onclick = "cleanreq()" >
        <style>#cancel{display:none}</style>
                  <input style-display="none" class="btn btn-danger"  type="button" onClick="cancelReq()" value="Cancel" id="cancel">
        
    </div>
    <div class="col-lg-9">

        <table class="table" id="tbl">
        <thead>
        <tr>
            <th class="bg-dark">Creator</th>
            <th class="bg-dark">Id Request</th>
            <th class="bg-dark">Name Of the Query</th>
            <th class="bg-dark">Info Query</th>
            <th class="bg-dark">Statut Query</th>
            <th class="bg-dark">&nbsp;</th>
        </tr>

        </thead>
        <tbody>
        <?php
        foreach ($req as  $value) {

            $id=$value->id_user;
            $name_user = getNameUser($id);
        echo "<tr><td>".$name_user->name."</td>
        <td>".$value->id."</td>
        <td>".$value->query_name."</td>
        <td id=\"data-{$value->id}\" class=\"query\">".$value->query_data."</td> 
        <td>".$value->query_statut."</td>
        <td> <input type=\"button\" class=\"btn btn-primary\" value=\"Test\" nonclick=\"$('#sql').val($(this).parent().parent().find('td.query').html())\" onClick=\"testreq(".$value->id.")\" name=\"Test\" > </td>
        </tr>";
        }
        ?>
        </tbody>
        </table>
        
        <div class="row" >
        <div class="col-lg-12" id="sql-result">
                  
            </div>
            <input type="button" class="d-none btn btn-danger" value="Cancel"  onClick="cancelReq()">
        </div>    
    </div>

</div>



<?php
require_once 'javascripts.php';
require_once 'footer.php';
?>