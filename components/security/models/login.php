<?php
/* components/security/models/login.php
 *
 * Modelo de chequeo de cookie remember
 * Retorna json
 */

$db = include ROOTDIR.'/models/db.php';

function checkRemember($remember){
    global $db;
    $stmt = $db->query(
        "SELECT coo_info FROM cookies
        WHERE coo_val = '$remember'"
    );
    $rString = $stmt->fetch(PDO::FETCH_NUM)[0];
    if(isset($rString)){
        session_start();
        $obj = json_decode($rString);
        foreach ($obj as $key => $value) {
            $_SESSION[$key] = $value;
        }


        return '{"status": true, "msg": "Sesión activada"}';
    }

    return '{"status": false, "msg": "No se pudo recuperar la sesión"}';
}
