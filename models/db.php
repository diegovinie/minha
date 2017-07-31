<?php
/* db.php
 *
 * Modelo de conexión a la base de datos
 * Retorna un objeto PDO o un error PDOException
 */

include_once '../settings.php';

$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

try{
    $db = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME,
        DB_USER, DB_PWD, $options
    );
    return $db;
}catch(PDOException $err){
    echo 'Problema al conectar a la base de datos: '.$err->getMessage();
    return $err;
}
