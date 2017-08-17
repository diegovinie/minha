<?php
/* components/security/models/remembersession.php
 *
 * Modelo de chequeo de cookie remember
 * Retorna json
 */
defined('_EXE') or die('Acceso restringido');

$db = include ROOTDIR.'/models/db.php';

function checkRemember($remember){
    global $db;
    $status = false;

    $stmt = $db->prepare(
        "SELECT coo_info FROM cookies
        WHERE coo_val = :remember"
    );
    $stmt->bindValue('remember', $remember);
    $stmt->execute();

    $rString = $stmt->fetchColumn();
    if(!$rString){
        $msg = "No hay sesión guardada.";
    }
    else{
        if(!isset($_SESSION)) session_start();

        $obj = json_decode($rString);

        foreach ($obj as $key => $value) {
            $_SESSION[$key] = $value;
        }

        $status = true;
        $msg = "Sesión recuperada.";
    }

    return json_encode(array(
        'status' => $status,
        'msg' => $msg
    ));
}

function delRemember($remember){
    global $db;
    $e = $db->exec(
        "DELETE FROM cookies
        WHERE coo_val = '$remember'"
    );
    $status = $e? true : false;

    return json_encode(array('status' => $status));
}
