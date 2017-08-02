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
    $stmt = $db->query(
        "SELECT coo_info FROM cookies
        WHERE coo_val = '$remember'"
    );
    $rString = $stmt->fetch(PDO::FETCH_NUM)[0];
    if(isset($rString)){
        if(!isset($_SESSION)) session_start();
        $obj = json_decode($rString);
        foreach ($obj as $key => $value) {
            $_SESSION[$key] = $value;
        }

        return '{"status": true, "msg": "Sesión activada"}';
    }

    return '{"status": false, "msg": "No se pudo recuperar la sesión"}';
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
