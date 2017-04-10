<?php
function connect(){
    require 'datos.php';
    $con = mysql_connect($db_host, $db_user, $db_pwd) or die("Error de conexión: ". mysql_error());
    mysql_select_db($db_name) or die("No seleccionó la base de datos: " . mysql_error());
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

?>
