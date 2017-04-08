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

?>
