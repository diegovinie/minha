<?php
/* components/security/models/users.php
 *
 */

defined('_EXE') or die('Acceso restringido');

include_once ROOTDIR.'/models/db.php';

function getEmail($id){
    $db = connectDb();

    $stmt = $db->prepare(
        "SELECT user_user
        FROM glo_users
        WHERE user_id = :id"
    );
    $stmt->bindValue('id', $id, PDO::PARAM_INT);
    $res = $stmt->execute();

    if(!$res){
        return $stmt->errorInfo()[2];
    }
    else{
        return $stmt->fetchColumn();
    }
}

function checkEmail(/*string*/ $email){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt = $db->prepare(
        "SELECT user_id
        FROM glo_users
        WHERE user_user = :email"
    );
    $stmt->bindValue('email', $email);
    $res = $stmt->execute();

    if(!$res){
        $msg = "Error al consultar la base de datos";
    }
    else{
        if($stmt->rowCount() == 0){

            return false;
        }
        else{
            return true;
        }
    }
}
