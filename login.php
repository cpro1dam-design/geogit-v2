<?php 
require_once('inc/functions.php');
require_once 'inc/manager-db.php';
require_once 'header.php'; 


 if (isset($_GET['auth']) && intval($_GET['auth']) == 0){ 
  echo "<div class=\"alert alert-danger\">Invalid username or password <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
  <span aria-hidden=\"true\">&times;</span>
</button></div> " ;
 }

 ?>

<main role="main" class="flex-shrink-0">

  
    
    <section class="">
      
        <h1 class="jumbotron-heading text-center">Login</h1>
        
        <form method="POST" action="inc/log.php">
        <div class="main-form">
        <div class="form-group">
        <label for="user">ID(mail)</label>
        <input class="form-control" type="text" name="user">
          

      <label for="password">password</label>
      <input class="form-control"  type="password" name="password">
      
     </div>
      <input type="submit" value="connexion" class="form-control btn btn-outline-dark">
      <a href="register.php">Don't have an Account?</a>
       </div>
      </form>
     
    </section>
  
</main>

<?php
require_once 'javascripts.php';
require_once 'footer.php';
?>