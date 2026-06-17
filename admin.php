<?php 
require_once('inc/functions.php');
require_once 'inc/manager-db.php';
require_once 'header.php'; ?>

<?php  
$info = getAllInfoAcount();

$role = $_SESSION['role'];
?> 
<h1>Gestion</h1>
<div class="box shadow p-3">
      <div class="ribbon blue"><span><?php echo $role ;?></span></div>
<p>it is a space where the admin can manage all the users role and modify personal information</p>
      </div>
      <br>
      <section class="">
<div class="row">
      <div class="col-lg-12 text-center" id="tbl" style="padding-top:2em ">
<table class="table"  >
<thead>
<tr>
<th class="bg-dark">name</th>
<th class="bg-dark">firstname</th>
<th class="bg-dark">password</th>
<th class="bg-dark">mail</th>
<th class="bg-dark">role</th>
<th class="bg-dark">&nbsp;</th>
<th class="bg-dark">&nbsp;</th>
</tr>

</thead>
<tbody>
<?php
//var_dump($info);
    foreach ($info as $i => $value) {
        $id=$info[$i]->id;
        echo "<tr><td>".$info[$i]->name."</td>
                <td>".$info[$i]->firstname."</td>
                <td>*****</td>
                <td>".$info[$i]->mail."</td>
                <td>".$info[$i]->role."</td>
                
                <td><input type=\"button\" class=\"btn btn-primary\" onClick=\"modifInfoAccAdmin($id,'$role')\" value=\"Modify\"></td>
                <td> <input type=\"button\" class=\"btn btn-danger\" onClick=\"deleteme(".$id.")\" name=\"Delete\" value=\"Delete\"> </td></tr>";
                
                //<td><a href=\"user_delete.php?del_id= $id\" onclick="deleteme($id);">Supprimer</a></td>.</tr>";
    }

?>
</tbody>
</table>
</div>      
            <div class="alert alert-primary" id="rep" style="display:none">

                  </div>
                  <div class="main-form" > 
                  <form action="edit.php" method="post" id="form">
                     
                  </form>
                  </div> 
                 
            </div>
      </div>
</section>
<?php
require_once 'javascripts.php';
require_once 'footer.php';
?>