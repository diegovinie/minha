<?php
/* models/db.php
 *
 * Modelo de conexión a la base de datos
 * Retorna un objeto PDO o un error PDOException
 */

defined('_EXE') or die('Acceso restringido');

include_once ROOTDIR.'/models/pdoe.php';

function connectDb($prefix=null){

    if(!$prefix){
        if(isset($_SESSION['prefix'])) $prefix = $_SESSION['prefix'];
    }

    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );

    try{
        $db = new PDOe(
            "mysql:host=localhost;dbname=bd_minha",
            "root", "altura", $options, $prefix
        );
        return $db;

    }catch(PDOException $err){
        echo 'Problema al conectar a la base de datos: '.$err->getMessage();
        return false;
    }
}

function getPrefix(/*string*/ $email){
    $db = connectDb();

    $stmt = $db->prepare(
        "SELECT gam_id AS 'id'
        FROM glo_game
        WHERE gam_user = :email"
    );
    $stmt->bindValue('email', $email);
    $res = $stmt->execute();

    if(!$res){
        return false;
    }
    else{
        $id = $stmt->fetchColumn();

        return "u{$id}_";
    }
}
