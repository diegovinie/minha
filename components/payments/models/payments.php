<?php
/* components/payments/models/payments.php
 *
 * Modelo
 * Retorna un json (status, msg, [otros])
 */

defined('_EXE') or die('Acceso restringido');

include_once ROOTDIR.'/models/db.php';
include_once ROOTDIR.'/models/tables.php';
include_once ROOTDIR.'/models/modelresponse.php';

function getPayments(/*string*/ $bui, /*int*/ $napt){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;
    $header = array();
    $body = array();

    $stmt = $db->query(
        "SELECT `pay_id` AS 'id',
            `pay_date` AS 'Fecha',
            CASE pay_type
                WHEN 1 THEN 'Depósito'
                WHEN 2 THEN 'Transferencia' END AS 'Tipo',
            pay_op AS 'Num. Operación',
            bank_name AS 'Banco',
            pay_amount AS 'Monto'
        FROM {$prx}payments
        INNER JOIN {$prx}apartments ON pay_apt_fk = apt_id
        INNER JOIN glo_banks ON pay_bank_fk = bank_id
        WHERE apt_id = $napt AND pay_edf = '$bui'
        AND pay_check = 1"
    );

    if($stmt){
        $table = setTheadTbodyFromPDO($stmt);
        $status = true;

    }else{
        $status = false;

    }

    $response = array(
        'status' => $status,
        'table' => $table
    );
    return json_encode($response);
}

function getPendingPayments(/*string*/ $bui, /*int*/ $napt){
    $db = connectDb();
    $prx = $db->getPrx();

    $stmt = $db->query(
        "SELECT `pay_id` AS 'id',
            `pay_date` AS 'Fecha',
            CASE pay_type
                WHEN 1 THEN 'Depósito'
                WHEN 2 THEN 'Transferencia' END AS 'Tipo',
            pay_op AS 'Num. Operación',
            bank_name AS 'Banco',
            pay_amount AS 'Monto'
        FROM {$prx}payments
        INNER JOIN {$prx}apartments ON pay_apt_fk = apt_id
        INNER JOIN glo_banks ON pay_bank_fk = bank_id
        WHERE apt_id = $napt AND pay_edf = '$bui'
        AND pay_check = 0"
    );

    if($stmt){
        $table = setTheadTbodyFromPDO($stmt);
        $status = true;

    }else{
        $status = false;
    }

    $response = array(
        'status' => $status,
        'table' => $table
    );
    return json_encode($response);
}

function getReturnedPayments(/*string*/ $bui, /*int*/ $napt){
    $db = connectDb();
    $prx = $db->getPrx();

    $stmt = $db->query(
        "SELECT `pay_id` AS 'id',
        `pay_date` AS 'Fecha',
            CASE pay_type
                WHEN 1 THEN 'Depósito'
                WHEN 2 THEN 'Transferencia' END AS 'Tipo',
            pay_op AS 'Num. Operación',
            bank_name AS 'Banco',
            pay_amount AS 'Monto'
        FROM {$prx}payments
        INNER JOIN {$prx}apartments ON pay_apt_fk = apt_id
        INNER JOIN glo_banks ON pay_bank_fk = bank_id
        WHERE apt_id = $napt AND pay_edf = '$bui'
        AND pay_check = 2"
    );

    if($stmt){
        $table = setTheadTbodyFromPDO($stmt);
        $status = true;

    }else{
        $status = false;
    }

    $response = array(
        'status' => $status,
        'table' => $table
    );
    return json_encode($response);
}

function getBanks(){
    $db = connectDb();
    $prx = $db->getPrx();

    $stmt = $db->query(
        "SELECT bank_id AS 'id', bank_name AS 'name'
        FROM glo_banks"
    );
    if($stmt){
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $ind => $row) {
            foreach ($row as $key => $value) {
                $banks[$ind][$key] = $value;
            }
        }
    }
    return json_encode($banks);
}

function getApartmentId(/*string*/ $apt){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();

    $stmt = $db->prepare(
        "SELECT apt_id
        FROM {$prx}apartments
        WHERE apt_name = :apt
            AND apt_sim_fk = :simid"
    );
    $stmt->bindValue('apt', $apt);
    $stmt->bindValue('simid', $simid, PDO::PARAM_INT);

    $res = $stmt->execute();

    if(!$res){
        echo $stmt->errorInfo()[2];
        return false;
    }
    else{
        return $stmt->fetchColumn();
    }
}

function editPayment(/*int*/ $id){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;
    $data = array();

    $stmt = $db->query(
        "SELECT pay_id AS 'id', pay_date AS 'Fecha',
        pay_amount AS 'Monto', pay_op AS 'n_op',
        pay_fk_bank AS 'bankid', pay_type AS 'type',
        pay_obs AS 'notes'
        FROM {$prx}payments
        WHERE pay_id = $id"
    );

    if($stmt){
        foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $key => $val) {

            $data[$key] = $val;
        }
        $status = true;

    }
    return json_encode(array(
        'status' => $status, 'data' => $data
    ));
}

function removePayment(/*int*/ $id){
    $db = connectDb();
    $prx = $db->getPrx();

    $ex = $db->exec(
        "UPDATE {$prx}payments
        SET pay_check = 3
        WHERE pay_id = $id"
    );
    $status = $ex? true : false;
    $msg = $ex? 'Pago descartado' : 'No se pudo realizar la operación';

    return json_encode(array('status' => $status, 'msg' => $msg));
}

function sendPayment(/*array*/ $collection){
    $db = connectDb();
    $prx = $db->getPrx();
    $status = false;

    extract($collection);

    $stmt = $db->prepare(
        "INSERT INTO {$prx}payments
        (pay_date,      pay_edf,        pay_apt_fk,
         pay_hab_fk,    pay_type,       pay_op,
         pay_bank_fk,   pay_amount,
         pay_obs,     pay_check)
        VALUES
        (:date,         :edf,           :aptid,
         :habid,        :type,          :n_op,
         :bankid,       CAST(:amount AS DECIMAL(10,2)),
         :obs,        0)"
    );
    $stmt->bindValue('date', $date);
    $stmt->bindValue('edf', $edf);
    $stmt->bindValue('aptid', $aptid, PDO::PARAM_INT);
    $stmt->bindValue('habid', $habid, PDO::PARAM_INT);
    $stmt->bindValue('type', $type);
    $stmt->bindValue('n_op', $n_op);
    $stmt->bindValue('bankid', $bankid, PDO::PARAM_INT);
    $stmt->bindValue('amount', $amount);
    $stmt->bindValue('obs', $obs);

    $res = $stmt->execute();

    if(!$res){
        //$msg = 'No se pudo guardar el pago';
        $msg = $stmt->errorInfo()[2];
    }
    else{
        $msg = 'Pago guardado con éxito';
        $status = true;
    }

    return jsonResponse($status, $msg);
}



function old(){
    session_start();
    require_once '../datos.php';
    require_once ROOTDIR.'/server.php';
    require_once ROOTDIR.'/core/functions.php';
    connect();

    if(isset($_GET['arg']) && isset($_GET['fun'])){
        extract($_GET);
        $user = $_SESSION['user'];
        $bui = $_SESSION['bui'];
        $numapt = $_SESSION['number_id'];
        switch ($arg) {

            case 'editpayment':
                $q = "SELECT pay_id AS 'id', pay_date AS 'Fecha', pay_amount AS 'Monto', pay_op AS 'n_op', pay_fk_bank AS 'bankid', pay_type AS 'type', pay_obs AS 'notes' from payments WHERE pay_id = $id";
                $r = q_exec($q);
                echo json_encode(query_to_assoc($r)[0]);
                exit;
                break;
            case 'removepayment':
                $q = "UPDATE payments SET pay_check = 3 WHERE pay_id = $id";
                $r= q_exec($q);
                if($r){
                    echo '{"status": true, "msg": "borrado"}';
                }
                exit;
                break;
            default:
                # code...
                break;
        }

        $fun($q, $arg);
    }

    if(isset($_POST['type']) && isset($_POST['amount'])){
        extract($_POST);
        $bui = $_SESSION['bui'];
        $user = $_SESSION['user'];
        $number_id = $_SESSION['number_id'];
        $user_id = $_SESSION['user_id'];
        $amount = numToEng($amount);
        if(isset($chk) && $chk == 0){
            $q = "UPDATE payments SET pay_date = '$date', pay_type = $type, pay_op = '$n_op', pay_fk_bank = $bank , pay_amount = $amount, pay_check = 0, pay_obs = '$notes' WHERE pay_id = $id";
            $r = q_log_exec($user, $q);
            if($r){
                echo '{"status": true, "msg": "Actualizado"}';
            }else{
                echo '{"status": false, "msg": "No se pudo actualizar"}';
            }
        }else{

        }
    }

    if(isset($time_ini)) rec_exec_time($time_ini, __FILE__, __LINE__);


}
