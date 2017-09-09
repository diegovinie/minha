<?php
/* components/invoices/models/manage.php
 *
 * Modelo
 * Retorna un json con información para tablas
 */

defined('_EXE') or die('Acceso restringido');

include_once ROOTDIR.'/models/db.php';
include_once ROOTDIR.'/models/tables.php';
include_once ROOTDIR.'/models/modelresponse.php';

function getLapses(){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();

    $status = false;

    $stmt = $db->query(
        "SELECT lap_id AS 'id', lap_name AS 'name'
        FROM {$prx}lapses
        WHERE lap_exec = 0
            AND lap_sim_fk = $simid
        ORDER BY lap_id DESC"
    );

    if(!$stmt){
        $msg = 'Error al consultar datos.';
    }
    else{
        $status = true;
        $msg = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return jsonResponse($status, $msg);
}

function getBills(/*int*/ $buiid){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt = $db->prepare(
        "SELECT bil_id AS 'id',
            bil_date AS 'Fecha',
            act_name AS 'Actividad',
            bil_desc AS 'Desc',
            bil_total AS 'Monto'
        FROM {$prx}bills
            INNER JOIN glo_activities ON bil_act_fk = act_id
        WHERE bil_bui_fk = :buiid
            AND bil_lapse = 0
        ORDER BY bil_date DESC"
    );
    $stmt->bindValue('buiid', $buiid, PDO::PARAM_INT);
    $res = $stmt->execute();

    if(!$res){
        $msg = 'Error al consultar base de datos.';
    }
    else{
        $table = setTheadTbodyFromPDO($stmt);

        if(!$table){
            $msg = 'Error al construir la tabla';
        }
        else{
            $status = true;
            $msg = $table;
        }
    }
    return jsonTableResponse($status, $msg);
}

function getFunds(/*int*/ $buiid){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt = $db->prepare(
        "SELECT acc_id AS 'id',
            acc_name AS 'name',

            CASE acc_op
                WHEN 1 THEN 'Porcentaje'
                WHEN 2 THEN 'Monto'
                ELSE 'n/d' END AS type,
            acc_balance AS 'balance',
            CONVERT(acc_default, SIGNED) AS 'amount'
        FROM {$prx}accounts
            INNER JOIN glo_types ON acc_type_fk = type_id
        WHERE acc_bui_fk = :buiid
            AND type_name = 'fondo'"
    );
    $stmt->bindValue('buiid', $buiid, PDO::PARAM_INT);
    $res = $stmt->execute();

    if(!$res){
        $msg = 'Error al consultar base de datos.';
    }
    else{
        $status = true;
        $msg = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return jsonResponse($status, $msg);
}

function getBillInfo(){

}

function getInvoicesId(/*string*/ $bui){
    $status = false;

    $dir = ROOTDIR."/files/invoices/$bui";
    $dirmgr = opendir($dir);

    while(false !== ($fileName = readdir($dirmgr))){

        if($fileName != '.' && $fileName != '..'){
            $a = substr($fileName, 0, strrpos($fileName, "."));
            $index = substr($a, 4, strlen($a));
            $month = substr($index, -2, strlen($index));
            $year = substr($index, 0, 4);
            $invoices[$month.'/'.$year] = $index;
        }
    }

    if(!$invoices){
        $msg = 'No se obtuvo ningún resultado.';
    }
    else{
        $status = true;
        $msg = $invoices;
    }
    return jsonResponse($status, $msg);
}
