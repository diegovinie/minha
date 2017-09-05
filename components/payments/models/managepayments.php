<?php
/* components/payments/models/managepayments.php
 *
 * Modelo
 * Retorna un json (status, msg, [otros])
 */

defined('_EXE') or die('Acceso restringido');

include_once ROOTDIR.'/models/db.php';
include_once ROOTDIR.'/models/tables.php';
include_once ROOTDIR.'/models/modelresponse.php';

function getCurrentMonth(/*int*/ $buiid){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();

    $stmt = $db->prepare(
        "SELECT CASE pay_check
            WHEN 1 THEN 'Aprobados'
            WHEN 2 THEN 'Rechazados'
            WHEN 0 THEN 'Pendientes' END AS 'Condición',
            COUNT(pay_id) AS 'Cantidad', SUM(pay_amount) AS 'Monto'
        FROM {$prx}payments
            INNER JOIN {$prx}apartments ON pay_apt_fk = apt_id
        WHERE MONTH(pay_date) = MONTH(NOW())
            AND apt_bui_fk = :buiid
            AND apt_sim_fk = :simid
        GROUP BY pay_check"
    );
    $stmt->bindValue('buiid', $buiid);
    $stmt->bindValue('simid', $simid, PDO::PARAM_INT);

    $res = $stmt->execute();

    if(!$res){
        $status = false;
        $data = 'No se encontraros registros';
    }
    else{
        $status = true;
        $data = setTheadTbodyFromPDO($stmt);
    }

    return jsonTableResponse($status, $data);
}

function getLastMonth(/*int*/ $buiid){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();

    $stmt = $db->prepare(
        "SELECT CASE pay_check
            WHEN 1 THEN 'Aprobados'
            WHEN 2 THEN 'Rechazados'
            WHEN 0 THEN 'Pendientes' END AS 'Condición',
            COUNT(pay_id) AS 'Cantidad', SUM(pay_amount) AS 'Monto'
        FROM {$prx}payments
            INNER JOIN {$prx}apartments ON pay_apt_fk = apt_id
        WHERE MONTH(pay_date) = MONTH(NOW())-1
            AND apt_bui_fk = :buiid
            AND apt_sim_fk = :simid
        GROUP BY pay_check"
    );
    $stmt->bindValue('buiid', $buiid);
    $stmt->bindValue('simid', $simid, PDO::PARAM_INT);

    $res = $stmt->execute();

        if(!$res){
            $status = false;
            $data = 'No se encontraros registros';
        }
        else{
            $status = true;
            $data = setTheadTbodyFromPDO($stmt);
        }

    return jsonTableResponse($status, $data);
}

function getLastThreeMonths(/*int*/ $buiid){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();

    $stmt = $db->prepare(
        "SELECT lap_name AS 'Mes',
            SUM(pay_amount) AS 'Monto'
        FROM {$prx}payments
            INNER JOIN {$prx}apartments ON pay_apt_fk = apt_id
        WHERE MONTH(pay_date) > MONTH(NOW())-3
            AND pay_check = 0
            AND apt_bui_fk = :buiid
            AND apt_sim_fk = :simid
        GROUP BY pay_date
        LIMIT 3"
    );
    $stmt->bindValue('buiid', $buiid);
    $stmt->bindValue('simid', $simid, PDO::PARAM_INT);

    $res = $stmt->execute();

    if(!$res){
        $status = false;
        $data = 'No se encontraros registros';
    }
    else{
        $status = true;
        $data = setTheadTbodyFromPDO($stmt);
    }

    return jsonTableResponse($status, $data);
}

function approvedPayments(/*int*/ $buiid){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();


    $stmt = $db->prepare(
        "SELECT pay_id AS 'id',
            pay_date AS 'Fecha',
            apt_name AS 'Apartamento',
            pay_amount AS 'Monto',
            CASE pay_type
                WHEN 1 THEN 'Transferencia'
                WHEN 2 THEN 'Depósito'
                ELSE 'otro' END AS 'Forma de Pago',
                bank_name AS 'Banco',
                pay_op AS 'Num. Op.'
        FROM {$prx}payments
            INNER JOIN {$prx}apartments ON pay_apt_fk = apt_id
            INNER JOIN glo_banks ON pay_bank_fk = bank_id
        WHERE pay_check = 1
            AND apt_bui_fk = :buiid
            AND apt_sim_fk = :simid
        LIMIT 0, 10"
    );
    $stmt->bindValue('buiid', $buiid);
    $stmt->bindValue('simid', $simid, PDO::PARAM_INT);

    $res = $stmt->execute();


    if($stmt->rowCount() == 0 || !$res){

        $status = false;
        $data = 'No se encontraros registros';

    }else{
        $status = true;
        $data = setTheadTbodyFromPDO($stmt);
    }

    return jsonTableResponse($status, $data);
}

function refusedPayments(/*int*/ $buiid){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();

    $stmt = $db->prepare(
        "SELECT pay_id AS 'id',
            pay_date AS 'Fecha',
            pat_name AS 'Apartamento',
            pay_amount AS 'Monto',
            CASE pay_type
                WHEN 1 THEN 'Transferencia'
                WHEN 2 THEN 'Depósito'
                ELSE 'otro' END AS 'Forma de Pago',
                bank_name AS 'Banco',
                pay_op AS 'Num. Op.'
        FROM {$prx}payments
            INNER JOIN {$prx}apartments ON pay_apt_fk = apt_id
            INNER JOIN glo_banks ON pay_bank_fk = bank_id
        WHERE pay_check = 2
            AND apt_bui_fk = :buiid
            AND apt_sim_fk = :simid
        LIMIT 0, 10"
    );
    $stmt->bindValue('buiid', $buiid);
    $stmt->bindValue('simid', $simid, PDO::PARAM_INT);

    $res = $stmt->execute();

    if($stmt->rowCount() == 0 || !$res){
                echo "buu";
        $status = false;
        $data = 'No se encontraros registros';

    }else{
        $status = true;
        $data = setTheadTbodyFromPDO($stmt);
    }


    return jsonTableResponse($status, $data);
}

function pendingPayments(/*int*/ $buiid){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();

    $stmt = $db->prepare(
        "SELECT pay_id AS 'id',
            pay_date AS 'Fecha',
            apt_name AS 'Apartamento',
            pay_amount AS 'Monto',
            CASE pay_type
                WHEN 1 THEN 'Transferencia'
                WHEN 2 THEN 'Depósito'
                ELSE 'otro' END AS 'Forma de Pago',
            bank_name AS 'Banco',
            pay_op AS 'Num. Op.'
        FROM {$prx}payments
            INNER JOIN {$prx}apartments ON pay_apt_fk = apt_id
            INNER JOIN glo_banks ON pay_bank_fk = bank_id
        WHERE pay_check = 0
            AND apt_bui_fk = :buiid
            AND apt_sim_fk = :simid
        LIMIT 0, 10"
    );
    $stmt->bindValue('buiid', $buiid);
    $stmt->bindValue('simid', $simid, PDO::PARAM_INT);

    $res = $stmt->execute();

    if($stmt->rowCount() == 0){
        $status = false;
        $data = 'No se encontraros registros';

    }else{
        $status = true;
        $data = setTheadTbodyFromPDO($stmt);
    }


    return jsonTableResponse($status, $data);
}
