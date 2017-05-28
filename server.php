<?php
//Funciones de conexión a base de datos y manejo de datos
require_once ROOTDIR.'datos.php';

function connect(){
    $con = mysql_connect(DB_HOST, DB_USER, DB_PWD) or die("Error de conexión: ". mysql_error());
    mysql_select_db(DB_NAME) or die("No seleccionó la base de datos: " . mysql_error());
    mysql_query("SET NAMES 'utf8'");
    return $con;
}

function iconnect(){
    $con = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB_NAME);
    if(!$con){
        echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
        echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
        echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    mysqli_query($con, "SET NAMES 'utf8'");
    return $con;
}

//Ejecuta una consulta
function q_exec($query){
    //$q = mysql_real_escape_string($query);
//    $res = mysql_query($query) or die("No puede procesar la consulta: " .  mysql_error());
    $res = mysql_query($query) or die("No puede procesar la consulta");
    return $res;
}

//Ejecuta una consulta y guarda un registro del evento
function q_log_exec($user, $query){
    $q = mysql_escape_string($query);
    //$res = mysql_query($query) or die("No puede procesar la consulta: " . mysql_error());
    $res = mysql_query($query) or die("No puede procesar la consulta");
//    $log = mysql_query("INSERT INTO db_logs VALUES (NULL, NULL, '$user','$q')") or die("No almacenado en log ". mysql_error());
    $log = mysql_query("INSERT INTO db_logs VALUES (NULL, NULL, '$user','$q')");
    return $res;
}

//Recibe un objeto query_result y lo convierte en un array para poder ser codificado
function query_to_array($qresult){
    $raw = array();
    $i = 0;
    while($row = mysql_fetch_array($qresult)){
        $raw[$i] = $row;
        $i++;
    }
    return $raw;
}

function query_to_assoc($qresult){
    $raw = array();
    $i = 0;
    while($row = mysql_fetch_assoc($qresult)){
        $raw[$i] = $row;
        $i++;
    }
    return $raw;
}
?>
