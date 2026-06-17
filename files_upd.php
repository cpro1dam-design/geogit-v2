<?php 
require_once('inc/functions.php');
require_once 'inc/manager-db.php';
require_once 'header.php'; 
if ($_SESSION['role'] != "teacher") {
    header('location :index.php');
}?>
<h1>Prewiew</h1>
<div class="text-center">
    <textarea name="txt_files" id="textarea" cols="50" rows="13" placeholder="upload a file to prewiew here"></textarea>
    <div class="main-form">
        <form action="inc/upload.php" method="post" enctype="multipart/form-data">
<label for="formFileLg" class="form-label">choose an .sql files or .txt files to make an upload</label>
<input class="form-control form-control-lg" id="File" name="upload" type="file" onChange="pre_upload()"/>
<div class="row">

    <div class="col">
        <input type="button" value="Upload" class="form-control btn btn-info " name="submit" onClick="uploadSql()">
    </div>
    <div class="col">
        <input type="button" value="Cancel" class="form-control btn btn-danger" onClick="resetInput()">
    </div>
    <div class="col">
        <input type="button" value="Go back" class="form-control btn btn-dark" onClick="goBack()">
    </div>

</div>
</form>
</div>
</div>
    

<?php
require_once 'javascripts.php';
require_once 'footer.php';
?>