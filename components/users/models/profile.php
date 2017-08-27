<?php
/* components/users/models/profile.php
 *
 * Modelo
 * Retorna un json (status, msg, [otros])
 */

defined('_EXE') or die('Acceso restringido');

include ROOTDIR.'/models/db.php';
include ROOTDIR.'/models/modelresponse.php';

function getFromBuildings(/*int*/ $id){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt1 = $db->prepare(
        "SELECT bui_id AS 'id', bui_name AS 'name', bui_apt AS 'apt'
        FROM {$prx}buildings
        WHERE bui_id = :id"
    );
    $stmt1->bindValue('id', $id, PDO::PARAM_INT);
    $res = $stmt1->execute();

    if(!$res){
        $msg = 'Error al consultar datos';
    }
    else{
        $status = true;
        $msg = $stmt1->fetch(PDO::FETCH_ASSOC);
    }

    return jsonResponse($status, $msg);
}

function getFromUserdata(/*int*/ $userid){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt1 = $db->prepare(
        "SELECT udata_name AS 'name', udata_surname AS 'surname',
        udata_ci AS 'ci', udata_cel AS 'cel', udata_cond AS 'cond',
        udata_gender AS 'gender'
        FROM {$prx}userdata
        WHERE udata_user_fk = :userid"
    );
    $stmt1->bindValue('userid', $userid, PDO::PARAM_INT);
    $res1 = $stmt1->execute();

    if(!$res1){
        $msg = 'Error al consultar datos';
    }
    else{
        $status = true;
        $msg = $stmt1->fetch(PDO::FETCH_ASSOC);
    }

    return jsonResponse($status, $msg);
}

function getFromUsers(/*int*/ $id){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt1 = $db->query(
        "SELECT user_user AS 'email', user_type AS 'rol'
        FROM {$prx}users WHERE user_id = $id"
    );

    if(!$stmt1){
        $msg = 'Error al consultar datos';
    }
    else{
        $status = true;
        $msg = $stmt1->fetch(PDO::FETCH_ASSOC);
    }

    return jsonResponse($status, $msg);
}

function getNotesFromBuildings(/*int*/ $id){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt1 = $db->query(
        "SELECT bui_notes AS 'notes'
        FROM {$prx}buildings
        WHERE bui_id = $id"
    );

    if(!$stmt1){
        $msg = 'Error al consultar datos';
    }
    else{
        $status = true;
        $msg = json_decode($stmt1->fetch(PDO::FETCH_NUM)[0]);
    }

    return jsonResponse($status, $msg);
}

function updateUserdata(/*int*/     $id,
                        /*string*/  $name,
                        /*string*/  $surname,
                        /*string[9]*/  $ci,
                        /*string[11]*/  $cel,
                        /*string[1]*/ $gender){

    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt1 = $db->prepare(
        "UPDATE {$prx}userdata
        SET udata_name = :name,
        udata_surname = :surname,
        udata_ci = :ci,
        udata_cel = :cel,
        udata_gender = :gender
        WHERE udata_user_fk = :id"
    );
    $res1 = $stmt1->execute(array(
        'name'      => $name,
        'surname'   => $surname,
        'ci'        => $ci,
        'cel'       => $cel,
        'gender'    => $gender,
        'id'        => $id
    ));

    if(!$res1){
        //$msg = $db->errorInfo();
        $msg = 'Error al consultar base de datos.';
    }
    else{
        $status = true;
        $msg = 'Cambios guardados con éxito.';
    }

    return jsonResponse($status, $msg);
}

function updateNotes(/*int*/ $buiid, /*array*/ $notes){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt1 = $db->prepare(
        "UPDATE {$prx}buildings
        SET bui_notes = :notes
        WHERE bui_id = :buiid"
    );
    $res1 = $stmt1->execute(array(
        'notes' => $notes,
        'buiid' => $buiid
    ));

    if(!$res1){
        //$msg = $db->errorInfo();
        $msg = 'Error al consultar base de datos.';
    }
    else{
        $status = true;
        $msg = 'Cambios guardados con éxito.';
    }

    return jsonResponse($status, $msg);
}
