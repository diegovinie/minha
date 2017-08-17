<?php
/* models/main.php
 *
 */

defined('_EXE') or die('Acceso restringido');

$db = include ROOTDIR.'/models/db.php';

function getBalance($napt){
    global $db;
    $status = false;

    $stmt = $db->prepare(
        "SELECT bui_name, bui_apt, bui_balance
        FROM buildings
        WHERE bui_id = :napt"
    );
    $stmt->bindValue('napt', $napt, PDO::PARAM_INT);
    $stmt->execute();

    if($stmt){
        $status = true;
        foreach($stmt->fetchAll() as $row){
            foreach ($row as $key => $value) {
                $data[$key] = $value;
            }
        }
    }else{
        $data = 'Error al consultar la base de datos.';
    }

    $response = array('status' => $status, 'data' => $data);
    return json_encode($response);
}

/* Posiblemente sin uso, pendiente borrar

function checkDefPwd($userid){
    global $db;
    $stmt = $db->prepare(
        "SELECT user_pwd FROM users
        WHERE user_id = :userid"
    );
    $stmt->bindValue('userid', $userid, PDO::PARAM_INT);
    $stmt->execute();

    $res = $stmt->rowCount();

    $status = $res === 2? true : false;

    //return json_encode(array('status' => $status));
    return 'hola aqui';
}
*/
