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

    $status = false;

    $stmt = $db->query(
        "SELECT lap_id AS 'id', lap_name AS 'name'
        FROM glo_lapses
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

function getBills(/*string*/ $bui){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt = $db->prepare(
        "SELECT bil_id AS 'id', bil_date AS 'Fecha',
        bil_class AS 'Clase', bil_desc AS 'Desc',
        bil_total AS 'Monto'
        FROM {$prx}bills
        WHERE bil_bui = :bui AND bil_lapse_fk = 0
        ORDER BY bil_date DESC"
    );
    $stmt->bindValue('bui', $bui);
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

function getFunds(/*string*/ $bui){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt = $db->prepare(
        "SELECT fun_id AS 'id', fun_name AS 'name',
        fun_balance AS 'balance', fun_type AS type,
        CONVERT(fun_default, SIGNED) AS 'amount'
        FROM {$prx}funds
        WHERE fun_bui = :bui"
    );
    $stmt->bindValue('bui', $bui);
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
