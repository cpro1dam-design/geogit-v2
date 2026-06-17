<?php 
require_once('inc/functions.php');
require_once 'inc/manager-db.php';
require_once 'header.php'; ?>

<main role="main" class="flex-shrink-0">

  
    
    <section class="">
      
        <h1 class="jumbotron-heading text-center">Register</h1>


        <form method="POST" action="inc/reg.php" class="main-form" id="form">
        <div  class="form-group">
          <div class="row">
          <div class="col">
          <label for="name">firstname</label>
          <input class="form-control" type="text" name="name" required>
          </div>

          <div class="col">
          <label for="firstname">lastname</label>
          <input class="form-control"  type="text" name="firstname" required></div>
          </div>

          <label for="ID">ID(mail)</label>
          <input class="form-control"  type="text" name="ID" id="mail" onKeydown="checkEmail()" required>

           <label for="mdp">password</label>
           <input class="form-control" type="password" name="mdp" id ="mdp"required>

           <label for="mdpconf">confirm password</label>
           <input class="form-control" type="password" name="mdpconf" id="mdpconf" onChange="confPass()" required>
           <p class="alert alert-danger" style="display:none" id="error">the password doesn't match</p>
      
      
      
      </div>
      <input  type="submit" value="connexion" class="form-control btn btn-dark text-center">
      <a href="login.php" class="outline-dark">Already have an account?</a>
        </form>


     
    </section>
  
</main>

<?php
require_once 'javascripts.php';
require_once 'footer.php';
?>
