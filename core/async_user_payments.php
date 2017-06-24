<?php
// Controlador: user_payments.php
// Vista: user/user_payments.php, templates/payment.html

session_start();
require_once '../datos.php';
require_once ROOTDIR.'/server.php';
require_once ROOTDIR.'/core/tables.php';
connect();

if(isset($_GET['arg']) && isset($_GET['fun'])){
    extract($_GET);
    $user = $_SESSION['user'];
    $bui = $_SESSION['bui'];
    switch ($arg) {
        case 'pagos':
            $q = "SELECT `pay_id` AS 'id', `pay_date` AS 'Fecha', CASE pay_type
            WHEN 1 THEN 'Depósito'
            WHEN 2 THEN 'Transferencia'
            END AS 'Tipo', pay_op AS 'Num. Operación', bank_name AS 'Banco', pay_amount AS 'Monto' FROM `payments` INNER JOIN users ON pay_fk_user = user_id INNER JOIN banks ON pay_fk_bank = bank_id
            WHERE user_user = '$user' AND pay_bui = '$bui' AND pay_check = 1";
            break;
        case 'pagos_en_revision':
            $q = "SELECT `pay_id` AS 'id', `pay_date` AS 'Fecha', CASE pay_type
            WHEN 1 THEN 'Depósito'
            WHEN 2 THEN 'Transferencia'
            END AS 'Tipo', pay_op AS 'Num. Operación', bank_name AS 'Banco', pay_amount AS 'Monto' FROM `payments` INNER JOIN users ON pay_fk_user = user_id INNER JOIN banks ON pay_fk_bank = bank_id
            WHERE user_user = '$user' AND pay_bui = '$bui' AND pay_check = 0";
            break;
        case 'devueltos':
            $q = "SELECT `pay_id` AS 'id', `pay_date` AS 'Fecha', CASE pay_type
            WHEN 1 THEN 'Depósito'
            WHEN 2 THEN 'Transferencia'
            END AS 'Tipo', pay_op AS 'Num. Operación', bank_name AS 'Banco', pay_amount AS 'Monto' FROM `payments` INNER JOIN users ON pay_fk_user = user_id INNER JOIN banks ON pay_fk_bank = bank_id
            WHERE user_user = '$user' AND pay_bui = '$bui' AND pay_check = 2";
            break;
        case 'banks':
            $q = "SELECT bank_id, bank_name FROM banks";
            $r = q_exec($q);
            echo json_encode(query_to_assoc($r));
            exit;
            break;
        case 'apt':
            $number_id = $_SESSION['number_id'];
            $q = "SELECT bui_name, bui_apt FROM buildings WHERE bui_id = '$number_id'";
            $r = q_exec($q);
            echo toJson($r);
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
    $q = "INSERT INTO payments VALUES (NULL, '$date', '$bui', '$number_id', '$type', '$n_op', $bank, $amount, 0, '$notes', NULL, '$user_id')";
    $r = q_log_exec($user, $q);
    if($r){
        echo '{"status": true, "msg": "Pago registrado exitosamente"}';
    }else{
        echo '{"status": false, "msg": "No se pudo registrar el pago"}';
    }
}

function pays($q, $id){
    $r = q_exec($q);
    table_open($id);
    table_head($r);
    table_tbody($r);
    table_close();
}
if(isset($time_ini)) rec_exec_time($time_ini, __FILE__, __LINE__);
 ?>
