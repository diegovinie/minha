<?php
/* models/main.php
 *
 */

defined('_EXE') or die('Acceso restringido');

$db = include ROOTDIR.'/models/db.php';

function getBalance($napt){
    global $db;
    $stmt = $db->query(
        "SELECT bui_name, bui_apt, bui_balance FROM buildings
        WHERE bui_id = $napt"
    );
    if($stmt){
        $status = true;
        foreach($stmt->fetchAll() as $row){
            foreach ($row as $key => $value) {
                $data[$key] = $value;
            }
        }
    }else{
        $status = false;
    }
    $response = array('status' => $status, 'data' => $data);
    return json_encode($response);
}

function checkDefPwd($userid){
    global $db;
    $stmt = $db->query(
        "SELECT user_pwd FROM users
        WHERE user_id = $userid"
    );
    $res = $stmt->fetch(PDO::FETCH_NUM)[0];

    $status = $res == 1? true : false;

    //return json_encode(array('status' => $status));
    return 'hola aqui';
}
