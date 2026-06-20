<?php
/**
 * Génération du HTML — tables, formulaires et listes d'options.
 * (Fonctions extraites de functions.php — comportement inchangé.)
 *
 * Remarque : ces fonctions s'appuient sur la couche d'accès aux données
 * (getCountriesByContinent, getKey…) chargée via inc/manager-db.php.
 */

function buildOptionForCont($continent){
    $options = '';
    $country = getCountriesByContinent($continent);
    foreach ($country as $value) {
        $options .= "<option value=\"{$value->id}\">".htmlspecialchars($value->Name)."</option>";
    }

    return $options;
}

function buildTable($rows){
    if (count($rows) == 0) {
        echo "Aucun résultat trouvé ! <br> <input type=\"button\" class=\"btn btn-danger\" value=\"Cancel\" onClick=\"cancelReqMana()\">";
         } else {
        echo "<table class=\"table\">
            <thead>
                <tr>";

                $tableHeaders = array_keys(get_object_vars($rows[0]));
                foreach($tableHeaders as $headerName){ echo "<th class=\"bg-dark\">".htmlspecialchars($headerName)."</th>";}

               echo" </tr>
            </thead>
            <tbody>";

                foreach($rows as $r) {
                    echo "<tr>\r\n";
                    foreach($r as $value){ echo "<td>".htmlspecialchars($value)."</td>";}
                    echo "</tr>\r\n";
                }

                  echo"</tbody>
                    </table>";

 }
}

function buildTableReqTest($rows){
    if (count($rows) == 0){
        echo "Aucun résultat trouvé !";
     } else {
         echo "<table class=\"table\" id=\"tbl\" style=\"padding-top : 1em\"><thead><tr>";

            $tableHeaders = array_keys(get_object_vars($rows[0]));
            foreach($tableHeaders as $headerName){
                if (substr(strtolower($headerName), 0, 2) == 'id') continue;
                echo "<th class=\"bg-dark\">".htmlspecialchars($headerName)."</th>";
            }
            echo "<th class=\"bg-dark\">&nbsp;</th>
                <th class=\"bg-dark\">&nbsp;</th>
                </tr></thead><tbody>";

                foreach($rows as $r) {
                    $id = $r->id;
                    echo "<tr>\r\n";
                    foreach($r as $val =>$value){
                        if (substr(strtolower($val), 0, 2) == 'id') continue;
                        if ($val == "query_data") {
                            //var_dump($val);
                            echo "<td id=\"data-{$id}\" class=\"query\">".htmlspecialchars($value)."</td>";
                            continue;
                        } echo "<td>".htmlspecialchars($value)."</td>";

                        }
            echo "<td><input type=\"button\" class=\"btn btn-success\" value=\"Tester\" onclick=\"tst_req(".$id.")\"></td>
             <td><input type=\"button\" onClick=\"deletereq(".$id.")\" class=\"btn btn-danger\" name=\"Delete\" value=\"Delete\"></td></tr>\r\n";
        }
       echo"</tbody></table>"; }
}

function buildOptionForTables($tables){
    $options = '<option value="*">Select a table</option>';
    foreach($tables as $t) {
        foreach($t as $value) {
            if ($value == "users" OR $value == "query") {
                continue;
            } else {
                $options .= "<option value=\"$value\">".htmlspecialchars($value)."</option>";
            }
        }
    }

    return $options;
}

function buildOptionForColumns($columns){
    $options = '';
    foreach($columns as $c) {
        if ($c->Key != '') continue;
        $options .= "<option value=\"{$c->Field}\">".htmlspecialchars($c->Field)."</option>";
    }

    return $options;
}

function buildTableNoId($rows,$table){
    if (count($rows) == 0) {

        echo "Aucun résultat trouvé !";
         } else {
            $test = getKey($table);
          //echo "<div class=\"alert alert-danger\">";

        foreach ($test as $obj ) {
            // echo  $obj->Field .": ".$obj->Key."<br>";
             $f[]=$obj->Field;
             $k[]=$obj->Key;
          }
          $priCount=0;
          /*var_dump($test);
          var_dump($f);
          var_dump($k);*/
          //echo"</div>";
        echo "<table class=\"table \">
            <thead>
                <tr >";

                $tableHeaders = array_keys(get_object_vars($rows[0]));
                foreach($tableHeaders as $headerName ){
                    for ($i=0; $i <count($f) ; $i++) {
                         if ($headerName == $f[$i] ) {
                               if ($k[$i] == "PRI" OR $k[$i] == "MUL" ) {
                                   $priId[]=$f[$i];
                                   $priCount++;
                                   continue;
                               }else{
                                   echo "<th class=\"bg-dark\">".htmlspecialchars($headerName)."</th>";}
                           }
                       }
                }
                echo" </tr>
                </thead>
                <tbody>";
                //var_dump($priId);
                //var_dump($priCount);
                foreach($rows as $r) {
                    //var_dump($r);
                    $jsKey = [];
                    foreach ($priId as $fn) {
                        $jsKey[] = $r->$fn;
                    }
                    if ($priCount >= 2) {
                        echo "<tr onClick=\"selectLine([".implode(',', $jsKey)."],'$table')\" class=\"table-select\">\r\n";
                    }
                    else {
                        echo "<tr onClick=\"selectLine($r->id,'$table')\" class=\"table-select\">\r\n";
                    }
                    foreach($r as $name => $value) {

                        for ($i=0; $i <count($f) ; $i++) {
                            if ($name == $f[$i] ) {
                                  if ($k[$i] == "PRI" OR $k[$i] == "MUL" ) {
                                      continue;
                                  }else{
                                    echo "<td name=\"$value\">".htmlspecialchars($value)."</td>";}
                              }
                          }
                   }

                    }
                    echo "</tr>\r\n";
                }

                  echo"</tbody>
                    </table>";

 }


function  buildForm($row,$table){
    echo "UPDATE $table SET ";
    /*
       $columns = array_keys(get_object_vars($row));
       foreach($columns as $column){  echo $column ." =  <input type=\"text\" name =\"{$column}\" value=\"\"><br>";}
    */ echo "<div class=\"row\"> ";
    $i=0;
    $test = getKey($table);
    foreach ($test as $obj ) {
           //echo  $obj->Field .": ".$obj->Key."<br>";
           $f[]=$obj->Field;
           $k[]=$obj->Key;
        }
    foreach($row as $name => $value){




        for ($d=0; $d <count($f) ; $d++) {


            if ($name == $f[$d] ) {
                //var_dump($f);
                if ($k[$d] == "PRI" OR $k[$d] == "MUL" ) {
                    //var_dump($k);
            echo "<input type=\"hidden\" name=\"{$name}\" value=\"{$value}\">";
            continue;
                }
            }
        };if ($i == 0) {
            echo"<div class=\"form-group\">";
        };
         echo $name ." =  <div class=\"col\"><input type=\"text\" class=\"form-control\" name =\"{$name}\" value=\"{$value}\"></div>";
        $i++;
         if ($i == 2) {
            echo"</div>";
            $i=0;
        };
            }echo "</div>";
}

function  buildFormModif($user,$role){
    echo"<div class=\"main-form bg-glass\">
    <div class=\"form-group\">";
    foreach($user as $name => $value){
        if ($name == "id" ){
            echo "<input type=\"hidden\" name=\"{$name}\" value=\"{$value}\">";
            continue;
            } elseif ($name == "password") {
                echo  "  <label for=\"{$name}\">$name</label><input class=\"form-control\" type=\"{$name}\" name=\"{$name}\" value=\"*******\"><br>";
                continue;
                } elseif ($name == "role" && $value == "admin" or $name == "role" && $role !== "admin") {
                            echo  "  <label for=\"{$name}\">$name</label>
                            <input class=\"form-control-plaintext\" type=\"text\" name =\"{$name}\" value=\"{$value}\"readonly><br>";
                            continue;
                        }elseif ( $name == "role" && $role == "admin") {
                        echo  " <label for=\"{$name}\">$name</label>
                        <select  class=\"form-control\" name=\"{$name}\" id=\"role\">
                        <option value=\"{$value}\">{$value}</option>";
                        if($value == "student"){
                            echo "<option value=\"teacher\">teacher</option>
                            <option value=\"admin\">admin</option>
                            </select><br>";
                                } elseif ($value == "teacher") {
                                echo "<option value=\"student\">student</option>
                                <option value=\"admin\">admin</option>
                                </select><br>";
                                }
                        continue;
                    }

            echo  "  <label for=\"{$name}\">$name</label>
            <input class=\"form-control\" type=\"text\" name =\"{$name}\" value=\"{$value}\"><br>";
    }//var_dump($role);
    echo  "</div> <div class=\"row\"><div class=\"col\"><input type=\"submit\" class=\"form-control btn btn-success\" value=\"Update\" id=\"upd\" style=\"display: inline-block\"></div>
    <div class=\"col\"><input type=\"button\" class=\"form-control btn btn-info\" value=\"Cancel\"  onClick=\"cancelModif()\" id=\"cancel\" style=\"display: inline-block\"></div><div></div>";
}

function buildInfoTableAdmin($info,$role){
  echo  "<table class=\"table\" id=\"tbl\">
<thead>
<tr>
<th class=\"bg-dark\">name</th>
<th class=\"bg-dark\">firstname</th>
<th class=\"bg-dark\">password</th>
<th class=\"bg-dark\">mail</th>
<th class=\"bg-dark\">role</th>
<th class=\"bg-dark\">&nbsp;</th>
<th class=\"bg-dark\">&nbsp;</th>
</tr>

</thead>
<tbody>";

//var_dump($info);
    foreach ($info as $i => $value) {
        $id=$info[$i]->id;
        echo "<tr><td>".$info[$i]->name."</td>
                <td>".$info[$i]->firstname."</td>
                <td>*****</td>
                <td>".$info[$i]->mail."</td>
                <td>".$info[$i]->role."</td>

                <td><input type=\"button\" class=\"btn btn-primary\" onClick=\"modifInfoAccAdmin($id,'$role')\" value=\"Modify\"</td>
                <td> <input type=\"button\" class=\"btn btn-danger\" onClick=\"deleteme(".$id.")\" name=\"Delete\" value=\"Delete\"> </td></tr>";

                //<td><a href=\"user_delete.php?del_id= $id\" onclick="deleteme($id);">Supprimer</a></td>.</tr>";
    }

echo "</tbody></table>";
}

function buildInfoTable($info,$role){
    echo  "<table class=\"table\" id=\"tbl\">
  <thead>
  <tr>
  <th class=\"bg-dark\">name</th>
  <th class=\"bg-dark\">firstname</th>
  <th class=\"bg-dark\">password</th>
  <th class=\"bg-dark\">mail</th>
  <th class=\"bg-dark\">role</th>
  <th class=\"bg-dark\">&nbsp;</th>
  </tr>

  </thead>
  <tbody>";

  //var_dump($info);
 $id =  $info->id;

          echo "<tr><td>".$info->name."</td>
                  <td>".$info->firstname."</td>
                  <td>*****</td>
                  <td>".$info->mail."</td>
                  <td>".$info->role."</td>
                  <td><input type=\"button\" class=\"btn btn-primary\" onclick=\"modifInfoAcc($id,'$role')\"  value=\"Modify\"></td>
                  </tr>";

                  //<td><a href=\"user_delete.php?del_id= $id\" onclick="deleteme($id);">Supprimer</a></td>.</tr>";
  echo "</tbody></table>";
  }
