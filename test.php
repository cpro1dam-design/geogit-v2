<?php 
require_once('inc/functions.php');
require_once 'inc/manager-db.php';
require_once 'header.php'; ?>
<h1>Laboratory</h1>
<div class="box shadow p-3">
      <div class="ribbon"><span><?php echo $_SESSION['role']; ?></span></div>
<p>it is a space where you can test,save and create  SQL queries</p>
      </div><br>
<?php  $req = QueryById($_SESSION['id']);
//var_dump($req);?>

<section class="jumbotron text-center">
<div class="container" >

<div class="row">
    <div class="col-lg-3">
        <form action="inc/crea_req.php" method="post">

        <textarea class="textarea" name="testsql" id="sql" cols="30" rows="10" placeholder="SELECT..."></textarea>
        <br>
        <input type="button" value="Execute" onclick = "tst_req()">
        <input type="submit" value="Save">
        <input type="reset" value="Delete" onclick = "cleanreq()" >
        </form>
    </div>
    <div class="col-lg-9">
<caption>Your Queries</caption>
        <table class="table" id="tbl">
        <thead>
        <tr>
            <th>Creator</th>
            <th>Id Request</th>
            <th>Name Of the Query</th>
            <th>Info Query</th>
            <th>Statut Query</th>
            <th>&nbsp;</th>
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
        <td> <input type=\"button\" value=\"Test\" nonclick=\"$('#sql').val($(this).parent().parent().find('td.query').html())\" onClick=\"testreq(".$value->id.")\" name=\"Test\" > </td>
        </tr>";
        }
        ?>
        </tbody>
        </table>

    </div>    
</div>

<div class="row">
    <div class="col-lg-12" id="sql-result">****</div>
</div>

</div>


</section>
<?php
require_once 'javascripts.php';
require_once 'footer.php';
?>