
<script src="assets/library/jquery-3.1.1.js"> </script>
<script src="assets/bootstrap-4.2.1-dist/js/bootstrap.js"> </script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script >
    let loader = document.querySelector('.planet');
    let body = document.querySelector('body');
    let header = document.querySelector('header');
   /* 
    window.addEventListener("unload",function () {console.info(loader);
    $('.planet').fadeIn("fast");
    body.classList.toggle('loader');
    header.classList.toggle('loader');
      // $(loader).fadeOut("slow");
   })*/
// current state
console.log(document.readyState);

// print state changes
document.addEventListener('readystatechange', () => console.log(document.readyState));

if (document.readyState == 'loading') {
  // still loading, wait for the event
document.addEventListener("DOMContentLoaded",function () {console.info(loader);
    $('.planet').fadeIn("fast");
    body.classList.toggle('loader');
    header.classList.toggle('loader');
      // $(loader).fadeOut("slow");
   })
} else {
  
}
    /*)*/
   

    window.addEventListener('load',function () {console.log(loader);
        
        body.classList.toggle('loader');
    header.classList.toggle('loader');
    $(loader).fadeOut("slow");
        loader.parentElement.removeChild(loader);
    })
    
 function deleteme(del_id){
    if (confirm("Do you want to delete ")){ console.info('jhgig');
        window.location.href='inc/user_delete.php?del_id='+del_id+'';
        return true ;
    }
} 

$(document).ready(function() {
    $('#search').select2();
});


 function deletereq(del_idreq){
    if (confirm("Do you want to delete ")){ console.info('test');
        window.$.post('inc/user_delete.php',{del_idreq: del_idreq},function(response) {
        return true ;});
    }
} 


function testreq(id){
    var texte = document.getElementById("data-" + id).textContent;
    document.getElementById("sql").value = texte;
    //$('#sql').val(texte);

    console.log(document.getElementById("data-" + id));
    console.info(document.getElementById("sql"));

}

function cleanreq(){
document.getElementById("sql").value = "";
}

function upd_req(){
    var sql = document.getElementById("sql").value;//console.log(sql);
    $('#sql-result').html("Executing query...");
    $.post('get_sql_result.php', { sql: sql }, function(response) { //console.info(response);
        // document.getElementById("result").innerHtml = response;
        $('#sql-result').html(response);
    });
    
     document.getElementById("tbl").style.display="none";
     //document.getElementById("cancel").style.display = "inline";
     
/*
     console.log(  document.getElementById("sql"));
     console.log(testSql(req));
     console.log(document.getElementById("tbl").style.display="none");
     */ 
}


function tst_req(id){
    var sql = document.getElementById("data-"+id).textContent; console.info(sql);
      $('#sql-result').html("Executing query...");
    $.post('get_sql_result.php', { sql: sql }, function(response) { //console.info(response);
        // document.getElementById("result").innerHtml = response;
        $('#sql-result').html(response);
        document.getElementById("cancel").style.display = "inline";
        document.getElementById("sql-result").style.display = "block";
    });
    
     document.getElementById("tbl").style.display="none";
     
/*
     console.log(  document.getElementById("sql"));
     console.log(testSql(req));
     console.log(document.getElementById("tbl").style.display="none");
     */
    
}
function tst_reqPers(){
    
    var sql = document.getElementById("sql").value; console.info(sql);
      if (sql !== '' && sql.substr(0, 6).toLowerCase() == "select") {
        
    $('#sql-result').html("Executing query...");
    $.post('get_sql_result.php', { sql: sql }, function(response) { //console.info(response);
        // document.getElementById("result").innerHtml = response;
        $('#sql-result').html(response);
        document.getElementById("cancel").style.display = "inline";
        document.getElementById("sql-result").style.display = "block";
        document.querySelector('.testz').style.display = "block";
    });
    
     document.getElementById("tbl").style.display="none";
     
/*
     console.log(  document.getElementById("sql"));
     console.log(testSql(req));
     console.log(document.getElementById("tbl").style.display="none");
*/}else{
    $('#sql-result').html("<div class=\"alert alert-danger\">Incorrect querie format retry.</div>");
    document.getElementById("cancel").style.display = "inline";
}
}

function getColumns(table) {
    if (table == '*') return;
    console.info(table);
    $('#data').html("Data retrival ...");
    $.get('get_columns.php', { table: table }, function(response) { console.info(response);
        //$('#column').html(response);
        $('#data').html(response);
        document.getElementById("data").style.display = "block";
        document.getElementById("update").style.display = "none";
        document.getElementById("cancel").style.display = "none";
        document.getElementById("upd").style.display = "none";
        document.getElementById("upd").value = "";
    }); 
    document.getElementById("data").style.display = "block";   
}

function getColumnData(column) {
    if (column == '*') return;
    console.info(table);
    $.get('get_column_data.php', { column: column }, function(response) { console.info(response);
        $('#data').html(response);
    });    
}

function selectLine(id,table) {
    $('#upd').html("Data retrieval ...");
    $.get('inc/pre_update.php',{id: id , table: table} , function(response) { console.info(response);
        $('#upd').html(response);
      
        document.getElementById("update").style.display = "inline";
        document.getElementById("cancel").style.display = "inline";
               
    });
    document.getElementById("upd").style.display = "block"; 
  document.getElementById("data").style.display = "none";
}

function canceLine() {
   
        document.getElementById("data").style.display = "block";
        document.getElementById("update").style.display = "none";
        document.getElementById("cancel").style.display = "none";
        document.getElementById("upd").style.display = "none";
}

function cancelReq() {
   
   document.getElementById("tbl").style.display = "block";
   document.getElementById("cancel").style.display = "none";
   document.getElementById("sql-result").style.display = "none";
   document.getElementById("sql-result").value = "";
}

function cancelReqCrea() {
   
   
   document.getElementById("cancel").style.display = "none";
   document.querySelector('.testz').style.display = "none";
   document.getElementById("sql-result").value = "";
}

function ajouterParam(){

    var colOptions = $('#column').html();
    var colHtml = '<br>SET <select name="column[]">' + colOptions + '</select> =';
    var valueHtml = '<input type="text" name="value[]" placeholder="?">';

    $('#column-div').append(colHtml);
    $('#value-div').append(valueHtml);

    var plus = document.getElementById("column");
    var combo = document.createElement('select');
}

function cancelModif(){
     document.getElementById("tbl").style.display = "block"; 
     
       document.getElementById("form").style.display = "none";
       document.getElementById("form").value = '';
       
}

function modifInfoAcc(id,role){
    $('#rep').html("Data retrieval ...");
    $.get('user_edit.php',{id: id ,role: role} , function(response) { console.info(response);
        $('#form').html(response);
       
        document.getElementById("rep").style.display = "none";
       document.getElementById("form").style.display = "block";            
    });
    document.getElementById("rep").style.display = "block";
    document.getElementById("tbl").style.display = "none";
}

function modifInfoAccAdmin(id,role){
    
    $('#rep').html("Data retrieval ...");
    $.get('inc/edit_Adm.php',{id: id ,role: role } , function(response) { console.info(response);
        $('#form').html(response);
       
        document.getElementById("rep").style.display = "none";
        document.getElementById("form").style.display = "inline-block";
               
    });
    
    document.getElementById("rep").style.display = "block";
    document.getElementById("tbl").style.display = "none"; 
    
}
 function goBack(){
     window.history.back();
 }


 function pre_upload() {
    $('#textarea').html("loading...");

    var blob = document.getElementById('File').files[0];

    var formData = new FormData();
    formData.append('upload', blob, blob.name);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'inc/prewiew_upload.php', true);
    xhr.onload = function(event) {
        if (this.status == 200) {
            $('#textarea').val(this.responseText);
        }
        //console.log(this.responseText, this.status);
        console.info('Terminé');
    }
    xhr.send(formData);

    /*
     var txt = document.getElementById('File').Content;//console.info(txt)
     
     $.post('inc/prewiew_upload.php',{txt:txt},function (response) {console.info(response);
         $('#textarea').html(response);
     } )
     */
 }

 function resetInput() {
    $('#File')[0].value = '';
    $('#textarea').value = "";

 }

 function confPass() {
     var mdp = document.getElementById('#mdp').textContent;
     var mdpConf = document.getElementByid('#mdpConf').textContent;

    if (mdp !== mdpConf) {
        document.getElementById('#error').style.display = "block";
    }
 }

 function checkEmail() {
     const form = document.getElementById('form');
     const email = document.getElementById('mail').value;
     const pattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+\.[a-z]{2,3}$/;
     
     if (email.match(pattern)){
         form.classList.add('valide');
         form.classList.remove('invalide');
     }else{
        form.classList.remove('valide');
        form.classList.add('invalide');
     }
 }


</script>