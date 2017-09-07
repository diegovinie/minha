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

    if($stmt->rowCount() == 0 || !$res){
        $status = false;
        $data = 'No se encontraros registros';

    }else{
        $status = true;
        $data = setTheadTbodyFromPDO($stmt);
    }


    return jsonTableResponse($status, $data);
}

function setApprovePayment($payid){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();
    $status = false;

    $stmt1 = $db->prepare(
        "SELECT pay_apt_fk AS 'aptid',
            pay_hab_fk AS 'habid',
            pay_amount AS 'amount'
            FROM {$prx}payments
            WHERE pay_id = :payid"
    );
    $stmt1->bindValue('payid', $payid, PDO::PARAM_INT);

    $res1 = $stmt1->execute();

    if(!$res1){
        $msg = $stmt1->errorInfo()[2];
    }
    else{
        $payment = $stmt1->fetch(PDO::FETCH_ASSOC);

        extract($payment);

        $exe2 = $db->exec(
            "UPDATE {$prx}accounts
            SET acc_balance = acc_balance + $amount
            WHERE acc_type = 1
                AND acc_sim_fk = $simid"
        );
        if(!$exe2){
            $msg = $db->errorInfo()[2];
        }
        else{
            $exe3 = $db->exec(
                "UPDATE {$prx}apartments
                SET apt_balance = apt_balance + $amount
                WHERE apt_id = $aptid"
            );

            if(!$exe3){
                $msg = $db->errorInfo()[2];
            }
            else{
                $exe4 =$db->exec(
                    "UPDATE {$prx}payments
                    SET pay_check = 1
                    WHERE pay_id = $payid"
                );

                if(!$exe4){
                    $msg = $db->errorInfo()[2];
                }
                else{
                    $status = true;
                    $msg = "Cambios guardados con éxito.";
                }
            }
        }
    }
    // avisar habid por correo
    return jsonResponse($status, $msg);
}

function setRefusePayment($payid, $obs=null){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();
    $status = false;

    $stmt1 = $db->prepare(
        "SELECT pay_hab_fk AS 'habid'
        FROM {$prx}payments
        WHERE pay_id = :payid"
    );
    $stmt1->bindValue('payid', $payid, PDO::PARAM_INT);

    $res1 = $stmt1->execute();

    if(!$res1){
        $msg = $stmt1->errorInfo()[2];
    }
    else{
        $stmt2 = $db->prepare(
            "UPDATE {$prx}payments
            SET pay_check = 2, pay_obs = :obs
            WHERE pay_id = :payid"
        );
        $stmt2->bindValue('obs', $obs);
        $stmt2->bindValue('payid', $payid, PDO::PARAM_INT);

        $res2 = $stmt2->execute();

        if(!$res2){
            $msg = $stmt2->errorInfo()[2];
        }
        else{
            $status = true;
            $msg = "Pago rechazado.";
            // Send email
        }
    }
    return jsonResponse($status, $msg);
}
