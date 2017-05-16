<?php
require_once '../datos.php';
require_once ROOTDIR.'/server.php';
require_once ROOTDIR.'/core/tables.php';
connect();

if(isset($_GET['fun'])){
    extract($_GET);
    switch ($arg) {
        case 'balance_apartamentos':
            $q = "SELECT A17_id AS 'id', A17_number AS 'Apartamento',
            A17_balance AS 'Deuda' FROM A17";
            $q_foot = "SELECT '' AS 'a', 'Deuda Total:' AS 'b',
            formatEsp(SUM(A17_balance)) AS 'c' FROM A17";
            break;
        case 'cuentas':
            $q = "SELECT acc_id AS 'id', acc_name AS 'Cuenta',
            user_user AS 'Custodio', A17_number AS 'Apartamento',
            formatEsp(acc_balance) AS 'Monto' FROM accounts, users, userdata,
            A17 WHERE acc_user = user_id AND acc_user = udata_user_fk
            AND udata_number_fk = A17_id";
            $q_foot = "SELECT '' AS 'a', 'Total en Cuentas:' AS 'b', '' AS 'c',
            '' AS 'd', formatEsp(SUM(acc_balance))
            AS 'total' FROM accounts";
            break;
        default:
            die;
            break;
    }

    if(isset($q_foot)){
        $r_body = q_exec($q);
        $r_foot = q_exec($q_foot);
        table_open($arg);
        table_head($r_body);
        table_tbody($r_body);
        table_tfoot($r_foot);
        table_close();
    }else{
        $fun($q, $arg);
    }
}

function aQuery($q, $id){
    $r = q_exec($q);
    tabla1($r, $id);
}
 ?>
