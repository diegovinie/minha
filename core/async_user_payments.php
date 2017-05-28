<?php
require_once '../datos.php';
require_once ROOTDIR.'/server.php';
require_once ROOTDIR.'/core/tables.php';
connect();

extract($_GET);

switch ($arg) {
    case 'pagos':
        $q = "SELECT `pay_id` AS 'id', `pay_date` AS 'Fecha', CASE pay_type
        WHEN 1 THEN 'Depósito'
        WHEN 2 THEN 'Transferencia'
        END AS 'Tipo', pay_op AS 'Num. Operación', bank_name AS 'Banco', pay_amount AS 'Monto' FROM `payments` INNER JOIN users ON pay_fk_user = user_id INNER JOIN banks ON pay_fk_bank = bank_id  WHERE user_user = '$user' AND pay_check = 1";
        break;
    case 'pagos_en_revision':
        $q = "SELECT `pay_id` AS 'id', `pay_date` AS 'Fecha', CASE pay_type
        WHEN 1 THEN 'Depósito'
        WHEN 2 THEN 'Transferencia'
        END AS 'Tipo', pay_op AS 'Num. Operación', bank_name AS 'Banco', pay_amount AS 'Monto' FROM `payments` INNER JOIN users ON pay_fk_user = user_id INNER JOIN banks ON pay_fk_bank = bank_id  WHERE user_user = '$user' AND pay_check = 0";
        break;
    case 'devueltos':
        $q = "SELECT `pay_id` AS 'id', `pay_date` AS 'Fecha', CASE pay_type
        WHEN 1 THEN 'Depósito'
        WHEN 2 THEN 'Transferencia'
        END AS 'Tipo', pay_op AS 'Num. Operación', bank_name AS 'Banco', pay_amount AS 'Monto' FROM `payments` INNER JOIN users ON pay_fk_user = user_id INNER JOIN banks ON pay_fk_bank = bank_id  WHERE user_user = '$user' AND pay_check = 2";
        break;
    default:
        # code...
        break;
}

$fun($q, $arg);

function pays($q, $id){
    $r = q_exec($q);
    table_open($id);
    table_head($r);
    table_tbody($r);
    table_close();
}

 ?>
