<?php
/* components/security/models/remembersession.php
 *
 * Modelo de chequeo de cookie remember
 * Retorna json
 */
defined('_EXE') or die('Acceso restringido');

include ROOTDIR.'/models/db.php';
include ROOTDIR.'/models/modelresponse.php';

function checkRemember(/*string*/ $remember){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt = $db->prepare(
        "SELECT coo_info FROM {$prx}cookies
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

    return jsonResponse($status, $msg);
}

function delRemember(/*string*/ $remember){
    $db = connectDb();
    $prx = $db->getPrx();
    
    $e = $db->exec(
        "DELETE FROM {$prx}cookies
        WHERE coo_val = '$remember'"
    );
    $status = $e? true : false;

    return jsonResponse($status, '');
}
