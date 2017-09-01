<?php
/* components/users/models/profile.php
 *
 * Modelo
 * Retorna un json (status, msg, [otros])
 */

defined('_EXE') or die('Acceso restringido');

include_once ROOTDIR.'/models/db.php';
include_once ROOTDIR.'/models/modelresponse.php';

function getFromApartments(/*int*/ $aptid){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt1 = $db->prepare(
        "SELECT apt_id AS 'id',
            apt_edf AS 'edf',
            apt_name AS 'name'
        FROM {$prx}apartments
        WHERE apt_id = :aptid"
    );
    $stmt1->bindValue('aptid', $aptid, PDO::PARAM_INT);
    $res1 = $stmt1->execute();

    if(!$res1){
        $msg = $stmt1->errorInfo()[2];
        //$msg = 'Error al consultar datos';
    }
    else{
        $status = true;
        $msg = $stmt1->fetch(PDO::FETCH_ASSOC);
    }

    return jsonResponse($status, $msg);
}

function getFromHabitants(/*int*/ $aptid){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt1 = $db->prepare(
        "SELECT hab_name AS 'name',
            hab_surname AS 'surname',
            hab_ci AS 'ci',
            hab_cel AS 'cel',
            hab_nac AS 'nac',
            hab_role AS 'role',
            hab_cond AS 'cond',
            hab_gender AS 'gender'
        FROM {$prx}habitants
        WHERE hab_apt_fk = :aptid"
    );
    $stmt1->bindValue('aptid', $aptid, PDO::PARAM_INT);
    $res1 = $stmt1->execute();

    if(!$res1){
        $msg = $stmt1->errorInfo()[2];
        //$msg = 'Error al consultar datos';
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
        "SELECT user_user AS 'email'
        FROM glo_users
        WHERE user_id = $id"
    );

    if(!$stmt1){
        $msg = $stmt1->errorInfo()[2];
        //$msg = 'Error al consultar datos';
    }
    else{
        $status = true;
        $msg = $stmt1->fetch(PDO::FETCH_ASSOC);
    }

    return jsonResponse($status, $msg);
}

function getNotesFromApartments(/*int*/ $aptid){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt1 = $db->prepare(
        "SELECT apt_notes AS 'notes'
        FROM {$prx}apartments
        WHERE apt_id = :aptid"
    );
    $stmt1->bindValue('aptid' , $aptid);
    $res1 = $stmt1->execute();

    if(!$res1){
        $msg = $stmt1->errorInfo()[2];
        //$msg = 'Error al consultar datos';
    }
    else{
        $status = true;
        $msg = json_decode($stmt1->fetch(PDO::FETCH_NUM)[0]);
    }

    return jsonResponse($status, $msg);
}

function updateHabitants(/*int*/     $habid,
                        /*string*/  $name,
                        /*string*/  $surname,
                        /*string[9]*/  $ci,
                        /*string*/  $nac,
                        /*string[11]*/  $cel,
                        /*string[1]*/ $gender){

    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt1 = $db->prepare(
        "UPDATE {$prx}habitants
        SET hab_name = :name,
            hab_surname = :surname,
            hab_ci = :ci,
            hab_nac = :nac,
            hab_cel = :cel,
            hab_gender = :gender
        WHERE hab_id = :habid"
    );
    $res1 = $stmt1->execute(array(
        'name'      => $name,
        'surname'   => $surname,
        'ci'        => $ci,
        'nac'       => $nac,
        'cel'       => $cel,
        'gender'    => $gender,
        'habid'     => $habid
    ));

    if(!$res1){
        //$msg = $stmt1->errorInfo()[2];
        $msg = 'Error al consultar base de datos.';
    }
    else{
        $status = true;
        $msg = 'Cambios guardados con éxito.';
    }

    return jsonResponse($status, $msg);
}

function updateNotes(/*int*/ $aptid, /*array*/ $notes){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt1 = $db->prepare(
        "UPDATE {$prx}apartments
        SET apt_notes = :notes
        WHERE apt_id = :aptid"
    );
    $res1 = $stmt1->execute(array(
        'notes' => $notes,
        'aptid' => $aptid
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
