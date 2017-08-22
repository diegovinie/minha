<?php
/* components/payments/models/payments.php
 *
 * Modelo
 * Retorna un json (status, msg, [otros])
 */

defined('_EXE') or die('Acceso restringido');

$db = include ROOTDIR.'/models/db.php';
include ROOTDIR.'/models/tables.php';
include ROOTDIR.'/models/modelresponse.php';

function getPayments($bui, $napt){

    global $db;
    $status = false;
    $header = array();
    $body = array();

    $stmt = $db->query(
        "SELECT `pay_id` AS 'id', `pay_date` AS 'Fecha',
        CASE pay_type
        WHEN 1 THEN 'Depósito'
        WHEN 2 THEN 'Transferencia' END AS 'Tipo',
        pay_op AS 'Num. Operación', bank_name AS 'Banco', pay_amount AS 'Monto'
        FROM `payments` INNER JOIN buildings ON pay_fk_number = bui_id INNER JOIN banks ON pay_fk_bank = bank_id
        WHERE bui_id = $napt AND pay_bui = '$bui' AND pay_check = 1"
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

function getPendingPayments($bui, $napt){

    global $db;
    $stmt = $db->query(
        "SELECT `pay_id` AS 'id', `pay_date` AS 'Fecha',
        CASE pay_type
        WHEN 1 THEN 'Depósito'
        WHEN 2 THEN 'Transferencia' END AS 'Tipo',
        pay_op AS 'Num. Operación', bank_name AS 'Banco', pay_amount AS 'Monto'
        FROM `payments` INNER JOIN buildings ON pay_fk_number = bui_id INNER JOIN banks ON pay_fk_bank = bank_id
        WHERE bui_id = $napt AND pay_bui = '$bui' AND pay_check = 0"
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

function getReturnedPayments($bui, $napt){
    // id3 = "devueltos"
    global $db;
    $stmt = $db->query(
        "SELECT `pay_id` AS 'id', `pay_date` AS 'Fecha',
        CASE pay_type
        WHEN 1 THEN 'Depósito'
        WHEN 2 THEN 'Transferencia' END AS 'Tipo',
        pay_op AS 'Num. Operación', bank_name AS 'Banco', pay_amount AS 'Monto'
        FROM `payments` INNER JOIN buildings ON pay_fk_number = bui_id INNER JOIN banks ON pay_fk_bank = bank_id
        WHERE bui_id = $napt AND pay_bui = '$bui' AND pay_check = 2"
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
    // 'core/async_user_payments.php?fun=&arg=banks'
    global $db;
    $stmt = $db->query(
        "SELECT bank_id AS 'id', bank_name AS 'name' FROM banks"
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

function editPayment($id){

    global $db;
    $status = false;
    $data = array();

    $stmt = $db->query(
        "SELECT pay_id AS 'id', pay_date AS 'Fecha', pay_amount AS 'Monto', pay_op AS 'n_op', pay_fk_bank AS 'bankid', pay_type AS 'type', pay_obs AS 'notes'
        FROM payments WHERE pay_id = $id"
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

function removePayment($id){

    global $db;
    $ex = $db->exec(
        "UPDATE payments SET pay_check = 3 WHERE pay_id = $id"
    );
    $status = $ex? true : false;
    $msg = $ex? 'Pago descartado' : 'No se pudo realizar la operación';

    return json_encode(array('status' => $status, 'msg' => $msg));
}

function sendPayment($collection){

    global $db;
    extract($collection);

    $exe = $db->exec(
        "INSERT INTO payments VALUES
        (NULL,
            '$date',
            '$bui',
            $napt,
            $type,
            '$n_op',
            $bank,
            $amount,
            0,
            '$notes',
            NULL,
            '$user_id')"
    );

    $status = $exe? true : false;
    $msg = $exe? 'Pago guardado con éxito' : 'No se pudo guardar el pago';

    return json_encode(array('status' => $status, 'msg' => $msg));
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
