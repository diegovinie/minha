<?php
/* components/finances/models/createaccount.php
 *
 * Modelo
 * Retorna un json con información para tablas
 */

defined('_EXE') or die('Acceso restringido');

include_once ROOTDIR.'/models/db.php';
include_once ROOTDIR.'/models/modelresponse.php';

function getHabitantsList($buiid){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();
    $status = false;

    $stmt = $db->prepare(
        "SELECT hab_id AS 'id',
            hab_name AS 'name',
            hab_surname AS 'surname',
            apt_name AS 'apt'
        FROM {$prx}habitants
            INNER JOIN {$prx}apartments ON hab_apt_fk = apt_id
        WHERE apt_bui_fk = :buiid
            AND apt_sim_fk = :simid"
    );
    $stmt->bindValue('buiid', $buiid, PDO::PARAM_INT);
    $stmt->bindValue('simid', $simid, PDO::PARAM_INT);

    $res = $stmt->execute();

    if(!$res){
        $msg = $stmt->errorInfo()[2];
    }
    else{
        $msg = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $status = true;
    }
    return jsonResponse($status, $msg);
}

function getAcctypesList(){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();
    $status = false;

    $res = $db->query(
        "SELECT s.type_id AS 'id',
            s.type_name AS 'name'
        FROM glo_types s
            INNER JOIN glo_types d ON s.type_ref = d.type_id
        WHERE d.type_name = 'acc_type'
            AND s.type_name != 'principal'
            AND s.type_name != 'fondo'"
    );

    if(!$res){
        $msg = $db->errorInfo()[2];
    }
    else{
        $msg = $res->fetchAll(PDO::FETCH_ASSOC);
        $status = true;
    }
    return jsonResponse($status, $msg); die;
}

function addAccount($buiid, $name, $typeid, $default, $habid){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();
    $status = false;

    $stmt = $db->prepare(
        "INSERT INTO {$prx}accounts
        (acc_name,      acc_balance,    acc_default,
         acc_type_fk,      acc_hab_fk,     acc_bui_fk,
         acc_sim_fk)
        VALUES
        (:name,        0,              :default,
         :typeid,       :habid,        :buiid,
         :simid)"
    );
    $stmt->bindValue('name', $name);
    $stmt->bindValue('default', $default);
    $stmt->bindValue('typeid', $typeid, PDO::PARAM_INT);
    $stmt->bindValue('habid', $habid, PDO::PARAM_INT);
    $stmt->bindValue('buiid', $buiid, PDO::PARAM_INT);
    $stmt->bindValue('simid', $simid, PDO::PARAM_INT);

    $res = $stmt->execute();

    if(!$res){
        $msg = $stmt->errorInfo()[2];
    }
    else{
        $msg = "Cuenta creada exitosamente.";
        $status = true;
    }
    return jsonResponse($status, $msg);
}
