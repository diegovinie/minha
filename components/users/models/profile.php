<?php
/* components/users/models/profile.php
 *
 * Modelo
 * Retorna un json (status, msg, [otros])
 */

defined('_EXE') or die('Acceso restringido');

$db = include ROOTDIR.'/models/db.php';

function getFromBuildings($id){
    global $db;
    $status = false;

    $stmt1 = $db->query(
        "SELECT bui_id AS 'id', bui_name AS 'name', bui_apt AS 'apt'
        FROM buildings WHERE bui_id = $id"
    );

    if(!$stmt1){
        $msg = 'Error al consultar datos';
    }
    else{
        $status = true;
        $msg = $stmt1->fetch(PDO::FETCH_ASSOC);
    }

    return json_encode(array(
        'status' => $status,
        'msg' => $msg
    ));

}

function getFromUserdata($userid){
    global $db;
    $status = false;

    $stmt1 = $db->query(
        "SELECT udata_name AS 'name', udata_surname AS 'surname',
        udata_ci AS 'ci', udata_cel AS 'cel', udata_cond AS 'cond',
        udata_gender AS 'gender' FROM userdata
        WHERE udata_user_fk = $userid"
    );

    if(!$stmt1){
        $msg = 'Error al consultar datos';
    }
    else{
        $status = true;
        $msg = $stmt1->fetch(PDO::FETCH_ASSOC);
    }

    return json_encode(array(
        'status' => $status,
        'msg' => $msg
    ));

}

function getFromUsers($id){
    global $db;
    $status = false;

    $stmt1 = $db->query(
        "SELECT user_user AS 'email', user_type AS 'rol'
        FROM users WHERE user_id = $id"
    );

    if(!$stmt1){
        $msg = 'Error al consultar datos';
    }
    else{
        $status = true;
        $msg = $stmt1->fetch(PDO::FETCH_ASSOC);
    }

    return json_encode(array(
        'status' => $status,
        'msg' => $msg
    ));
}

function getNotesFromBuildings($id){
    global $db;
    $status = false;

    $stmt1 = $db->query(
        "SELECT bui_notes AS 'notes' FROM buildings
        WHERE bui_id = $id"
    );

    if(!$stmt1){
        $msg = 'Error al consultar datos';
    }
    else{
        $status = true;
        $msg = json_decode($stmt1->fetch(PDO::FETCH_NUM)[0]);
    }

    return json_encode(array(
        'status' => $status,
        'msg' => $msg
    ));
}

function updateUserdata($id,
                        $name,
                        $surname,
                        $ci,
                        $cel,
                        $gender){

    global $db;
    $status = false;


    $exe1 = $db->exec(
        "UPDATE userdata
        SET udata_name = '$name', udata_surname ='$surname',
        udata_ci = '$ci', udata_cel = '$cel',
        udata_gender = '$gender'
        WHERE udata_user_fk = $id"
    );

    if(!$exe1){
        //$msg = $db->errorInfo();
        $msg = 'Error al consultar base de datos.';
    }
    else{
        $status = true;
        $msg = 'Cambios guardados con éxito.';
    }

    return json_encode(array(
        'status' => $status,
        'msg' => $msg
    ));

}

function updateNotes($buiid, $notes){
    global $db;
    $status = false;

    $exe1 = $db->exec(
        "UPDATE buildings
        SET bui_notes = '$notes'
        WHERE bui_id = $buiid"
    );

    if(!$exe1){
        //$msg = $db->errorInfo();
        $msg = 'Error al consultar base de datos.';
    }
    else{
        $status = true;
        $msg = 'Cambios guardados con éxito.';
    }

    return json_encode(array(
        'status' => $status,
        'msg' => $msg
    ));
}
