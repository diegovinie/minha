<?php
function connect(){
//    require 'datos.php';
    $con = mysql_connect(DB_HOST, DB_USER, DB_PWD) or die("Error de conexión: ". mysql_error());
    mysql_select_db(DB_NAME) or die("No seleccionó la base de datos: " . mysql_error());
    mysql_query("SET NAMES 'utf8'");
    return $con;
}

function q_exec($query){
    $res = mysql_query($query) or die("No puede procesar la consulta: " . mysql_error());
    return $res;
}

function q_log_exec($user, $query){
    $res = mysql_query($query) or die("No puede procesar la consulta: " . mysql_error());
    $q = mysql_escape_string($query);
    $log = mysql_query("INSERT INTO db_logs VALUES (NULL, NULL, '$user','$q')") or die("No almacenado en log ". mysql_error());
    return $res;
}

function ArrayToJson($qresult){
    $raw = array();
    $i = 0;
    while($row = mysql_fetch_array($qresult)){
        $raw[$i] = $row;
        $i++;
    }
    return $raw;
}

?>
