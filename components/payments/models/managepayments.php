<?php
/* components/payments/models/managepayments.php
 *
 * Modelo
 * Retorna un json (status, msg, [otros])
 */

defined('_EXE') or die('Acceso restringido');

$db = include ROOTDIR.'/models/db.php';
include ROOTDIR.'/models/tables.php';
include ROOTDIR.'/models/modelresponse.php';

function getCurrentMonth($bui){
    global $db;
    $stmt = $db->query(
        "SELECT CASE pay_check
        WHEN 1 THEN 'Aprobados'
        WHEN 2 THEN 'Rechazados'
        WHEN 0 THEN 'Pendientes' END AS 'Condición', COUNT(pay_id) AS 'Cantidad', SUM(pay_amount) AS 'Monto'
        FROM payments
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

function getLastMonth($bui){
    global $db;
    $stmt = $db->query(
        "SELECT CASE pay_check
        WHEN 1 THEN 'Aprobados'
        WHEN 2 THEN 'Rechazados'
        WHEN 0 THEN 'Pendientes' END AS 'Condición', COUNT(pay_id) AS 'Cantidad', SUM(pay_amount) AS 'Monto'
        FROM payments
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

function getLastThreeMonths($bui){
    global $db;
    $stmt = $db->query(
        "SELECT lap_name AS 'Mes', SUM(pay_amount)
        AS 'Monto' FROM payments
        INNER JOIN lapses ON MONTH(pay_date) = lap_id
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

function approvedPayments($bui){
    global $db;
    $stmt = $db->query(
        "SELECT pay_id AS 'id', pay_date AS 'Fecha', bui_apt
        AS 'Apartamento', pay_amount AS 'Monto',
        CASE pay_type
        WHEN 1 THEN 'Transferencia'
        WHEN 2 THEN 'Depósito'
        ELSE 'otro' END AS 'Forma de Pago',
        bank_name AS 'Banco', pay_op AS 'Num. Op.' FROM payments
        INNER JOIN buildings ON pay_fk_number = bui_id
        INNER JOIN banks ON pay_fk_bank = bank_id
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

function refusedPayments($bui){
    global $db;
    $stmt = $db->query(
        "SELECT pay_id AS 'id', pay_date AS 'Fecha', bui_apt
        AS 'Apartamento', pay_amount AS 'Monto',
        CASE pay_type
        WHEN 1 THEN 'Transferencia'
        WHEN 2 THEN 'Depósito'
        ELSE 'otro' END AS 'Forma de Pago',
        bank_name AS 'Banco', pay_op AS 'Num. Op.' FROM payments
        INNER JOIN buildings ON pay_fk_number = bui_id
        INNER JOIN banks ON pay_fk_bank = bank_id
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

function pendingPayments($bui){
    global $db;
    $stmt = $db->query(
        "SELECT pay_id AS 'id', pay_date AS 'Fecha', bui_apt
        AS 'Apartamento', pay_amount AS 'Monto',
        CASE pay_type
        WHEN 1 THEN 'Transferencia'
        WHEN 2 THEN 'Depósito'
        ELSE 'otro' END AS 'Forma de Pago',
        bank_name AS 'Banco', pay_op AS 'Num. Op.' FROM payments
        INNER JOIN buildings ON pay_fk_number = bui_id
        INNER JOIN banks ON pay_fk_bank = bank_id
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
