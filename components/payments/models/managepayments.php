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

function getCurrentMonth(/*string*/ $bui){
    $db = connectDb();
    $prx = $db->getPrx();

    $stmt = $db->query(
        "SELECT CASE pay_check
        WHEN 1 THEN 'Aprobados'
        WHEN 2 THEN 'Rechazados'
        WHEN 0 THEN 'Pendientes' END AS 'Condición',
        COUNT(pay_id) AS 'Cantidad', SUM(pay_amount) AS 'Monto'
        FROM {$prx}payments
        WHERE MONTH(pay_date) = MONTH(NOW()) AND pay_bui = '$bui' GROUP BY pay_check"
    );

    if($stmt){
        $status = true;

        $data = setTheadTbodyFromPDO($stmt);

    }else{

        $status = false;
        $data = 'No se encontraros registros';
    }

    return jsonTableResponse($status, $data);
}

function getLastMonth(/*string*/ $bui){
    $db = connectDb();
    $prx = $db->getPrx();

    $stmt = $db->query(
        "SELECT CASE pay_check
        WHEN 1 THEN 'Aprobados'
        WHEN 2 THEN 'Rechazados'
        WHEN 0 THEN 'Pendientes' END AS 'Condición',
        COUNT(pay_id) AS 'Cantidad', SUM(pay_amount) AS 'Monto'
        FROM {$prx}payments
        WHERE MONTH(pay_date) = MONTH(NOW())-1 AND pay_bui = '$bui' GROUP BY pay_check"
    );

    if($stmt){
        $status = true;

        $data = setTheadTbodyFromPDO($stmt);
    }else{

        $status = false;
        $data = 'No se encontraros registros';
    }

    return jsonTableResponse($status, $data);
}

function getLastThreeMonths(/*string*/ $bui){
    $db = connectDb();
    $prx = $db->getPrx();

    $stmt = $db->query(
        "SELECT lap_name AS 'Mes', SUM(pay_amount)
        AS 'Monto'
        FROM {$prx}payments
        INNER JOIN blo_lapses ON MONTH(pay_date) = lap_id
        WHERE pay_check = 0 AND pay_bui = '$bui'
        GROUP BY lap_name LIMIT 3"
    );

    if($stmt){
        $status = true;

        $data = setTheadTbodyFromPDO($stmt);
    }else{

        $status = false;
        $data = 'No se encontraros registros';
    }

    return jsonTableResponse($status, $data);
}

function approvedPayments(/*string*/ $bui){
    $db = connectDb();
    $prx = $db->getPrx();

    $stmt = $db->query(
        "SELECT pay_id AS 'id', pay_date AS 'Fecha', bui_apt
        AS 'Apartamento', pay_amount AS 'Monto',
        CASE pay_type
        WHEN 1 THEN 'Transferencia'
        WHEN 2 THEN 'Depósito'
        ELSE 'otro' END AS 'Forma de Pago',
        bank_name AS 'Banco', pay_op AS 'Num. Op.'
        FROM {$prx}payments
        INNER JOIN {$prx}buildings ON pay_fk_number = bui_id
        INNER JOIN glo_banks ON pay_fk_bank = bank_id
        WHERE pay_check = 1  AND pay_bui = '$bui'
        LIMIT 0, 10"
    );

    if($stmt){
        $status = true;

        $data = setTheadTbodyFromPDO($stmt);
    }else{

        $status = false;
        $data = 'No se encontraros registros';
    }

    return jsonTableResponse($status, $data);
}

function refusedPayments(/*string*/ $bui){
    $db = connectDb();
    $prx = $db->getPrx();

    $stmt = $db->query(
        "SELECT pay_id AS 'id', pay_date AS 'Fecha', bui_apt
        AS 'Apartamento', pay_amount AS 'Monto',
        CASE pay_type
        WHEN 1 THEN 'Transferencia'
        WHEN 2 THEN 'Depósito'
        ELSE 'otro' END AS 'Forma de Pago',
        bank_name AS 'Banco', pay_op AS 'Num. Op.'
        FROM {$prx}payments
        INNER JOIN {$prx}buildings ON pay_fk_number = bui_id
        INNER JOIN glo_banks ON pay_fk_bank = bank_id
        WHERE pay_check = 2  AND pay_bui = '$bui'
        LIMIT 0, 10"
    );

    if($stmt){
        $status = true;

        $data = setTheadTbodyFromPDO($stmt);
    }else{

        $status = false;
        $data = 'No se encontraros registros';
    }

    return jsonTableResponse($status, $data);
}

function pendingPayments(/*string*/ $bui){
    $db = connectDb();
    $prx = $db->getPrx();

    $stmt = $db->query(
        "SELECT pay_id AS 'id', pay_date AS 'Fecha', bui_apt
        AS 'Apartamento', pay_amount AS 'Monto',
        CASE pay_type
        WHEN 1 THEN 'Transferencia'
        WHEN 2 THEN 'Depósito'
        ELSE 'otro' END AS 'Forma de Pago',
        bank_name AS 'Banco', pay_op AS 'Num. Op.'
        FROM {$prx}payments
        INNER JOIN {$prx}buildings ON pay_fk_number = bui_id
        INNER JOIN glo_banks ON pay_fk_bank = bank_id
        WHERE pay_check = 0  AND pay_bui = '$bui'
        LIMIT 0, 10"
    );

    if($stmt){
        $status = true;

        $data = setTheadTbodyFromPDO($stmt);
    }else{

        $status = false;
        $data = 'No se encontraros registros';
    }

    return jsonTableResponse($status, $data);
}
