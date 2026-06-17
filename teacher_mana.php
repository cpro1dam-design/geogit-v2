
<?php 
require_once('inc/functions.php');
require_once 'inc/manager-db.php';
require_once 'header.php'; ?>
<h1>Management</h1>
<div class="box shadow p-3">
      <div class="ribbon red"><span><?php echo "teacher";?></span></div>
<p>it is a space where you can manage your SQL queries</p>
      </div>
      <br>
<?php
$info_q = QueryById($_SESSION['id']);
$name_user = getNameUser($_SESSION['id']);
//var_dump($name_user)

echo "<section class=\"\">";
echo buildTableReqTest($info_q);?>

        
      <div class="row" >
      <div class="col-lg-4" >
      <input type="button" value="Go back" id="cancel"onclick="cancelReq()" class="btn btn-info" style="display : none">
      </div>

      <div class="col-lg-8" id="sql-result">
      </div>

    </div>    

<!--<table class="table">
<thead>
<tr>
<th>name of the creator</th>
<th>id Request</th>
<th>name Of the Query</th>
<th>Info Query</th>
<th>Statut Query</th>

</tr>

</thead>
<tbody>
<?php/*
foreach ($info_q as  $value) {
    $id=$value->id;
echo "<tr><td>".$name_user->name."</td>
<td>".$id."</td>
<td>".$value->query_name."</td>
 <td>".$value->query_data."</td> 
<td>".$value->query_statut."</td>
<td><a href=\"test.php?id=".$id."\">Tester</a></td>
<td> <input type=\"button\" onClick=\"deletreq(".$id.")\" name=\"Delete\" value=\"Delete\"> </td></tr>";
}
*/?>
</tbody>
</table>
-->
</section>

<?php
require_once 'javascripts.php';
require_once 'footer.php';
?>