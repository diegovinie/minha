<?php
/* models/db.php
 *
 * Modelo de conexión a la base de datos
 * Retorna un objeto PDO o un error PDOException
 */

defined('_EXE') or die('Acceso restringido');

include_once ROOTDIR.'/models/pdoe.php';

function connectDb(/*string*/ $prefix=null){

    if(!$prefix){
        if(isset($_SESSION['prefix'])) $prefix = $_SESSION['prefix'];
    }

    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );

    try{
        $db = new PDOe(
            "mysql:host=".DB_HOST.";dbname=".DB_NAME,
            DB_USER,
            DB_PWD,
            $options,
            $prefix
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
        "SELECT sim_id AS 'id'
        FROM glo_simulator
        WHERE sim_user = :email"
    );
    $stmt->bindValue('email', $email);
    $res = $stmt->execute();

    if(!$res){
        echo $stmt->errorInfo()[2];
        return false;
    }

    $id = $stmt->fetchColumn();

    return "u{$id}_";
}

function getTypeId(/*string*/ $name){
    $db = connectDb();

    $stmt = $db->prepare(
        "SELECT type_id AS 'id'
        FROM glo_types
        WHERE type_name = :name"
    );
    $stmt->bindValue('name', $name);
    $res = $stmt->execute();

    if(!$res){
        echo $stmt->errorInfo()[2];
        return false;
    }
    else{

        return $stmt->fetchColumn();
    }
}

function addGetAiId(/*string*/ $name, /*string*/ $prefix=null){
    $db = connectDb($prefix);
    $prx = $db->getPrx();

    $id = getTypeId($name);

    $res = $db->query(
        "INSERT INTO {$prx}subjects
        VALUES(
            NULL,
            $id,
            0,
            1,
            NULL
        )"
    );

    if(!$res){
        echo $stmt->errorInfo()[2];
        return false;
    }

    return getlastId($prefix);
}

function addGetHumanId(/*string*/ $name, /*string*/ $prefix=null){
    $db = connectDb($prefix);
    $prx = $db->getPrx();

    $id = getTypeId($name);

    $res = $db->query(
        "INSERT INTO {$prx}subjects
        VALUES(
            NULL,
            $id,
            1,
            1,
            NULL
        )"
    );

    if(!$res){
        echo $stmt->errorInfo()[2];
        return false;
    }

    return getlastId($prefix);
}

function getLastId(/*string*/ $prefix=null){
    $db = connectDb($prefix);
    $prx = $db->getPrx();

    $res = $db->query(
        "SELECT sub_id
        FROM {$prx}subjects
        ORDER BY DESC
        LIMIT 1"
    );

    if(!$res){
        return false;
    }
    else{
        return $res->fetchColumn();
    }
}

function createDatabase(/*string*/ $name=null){

    $dbName = $name? $name : DB_NAME;

    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );

    try{
        $db = new PDOe(
            "mysql:host=".DB_HOST,
            DB_USER,
            DB_PWD,
            $options
        );

    }catch(PDOException $err){
        echo 'Problema al conectar a la base de datos: '.$err->getMessage();
        return false;
    }

    $exe = $db->exec("CREATE DATABASE IF NOT EXISTS $dbName");

    if(!$exe){
        echo $db->errorInfo()[2];
        return false;
    }
    else{
        return true;
    }
}
