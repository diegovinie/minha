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
            SUM(A17_balance) AS 'total' FROM A17";
            break;
        case 'cuentas':
            $q = "SELECT acc_id AS 'id', acc_name AS 'Cuenta',
            user_user AS 'Custodio', A17_number AS 'Apartamento',
            acc_balance AS 'Monto' FROM accounts, users, userdata,
            A17 WHERE acc_user = user_id AND acc_user = udata_user_fk
            AND udata_number_fk = A17_id";
            $q_foot = "SELECT '' AS 'a', 'Total en Cuentas:' AS 'b', '' AS 'c',
            '' AS 'd', SUM(acc_balance) AS 'total' FROM accounts";
            break;
        case 'fondos':
            $q = "SELECT fun_id AS 'id', fun_name AS 'Nombre', CASE fun_type
            WHEN 1 THEN 'Porcentaje' WHEN 2 THEN 'Monto' END AS 'Tipo', fun_default AS 'Cuota', fun_balance AS 'Monto' FROM funds WHERE fun_rel = 'A17' ";
            $q_foot = "SELECT '' AS 'a', 'Total en Fondos:' AS 'b', '' AS 'c',
            '' AS 'd', SUM(fun_balance) AS 'total' FROM funds";
            break;
        case 'apartamento':
            $q = "SELECT A17_number AS `Apto`, A17_balance AS `Deuda`,
                A17_assigned AS `Asignado?`, A17_occupied FROM A17, payments WHERE
                A17_id = '$id'";
            break;
        case 'corriente':
            $sq = "SELECT SUM(A17_balance) AS 'a' FROM A17";
            break;
        case 'total_fondos':
            $sq = "SELECT SUM(fun_balance) FROM funds WHERE fun_rel = 'A17'";
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
    }elseif(isset($sq)){
        $r = q_exec($sq);
        print_r(mysql_fetch_array($r)[0]);
    }
    else{
        if($fun == 'aQueryTbody'){
            $fun($q, $arg);
        }else{
            $fun($q, $arg);
        }
    }
}

function aQuery($q, $id){
    $r = q_exec($q);
    tabla1($r, $id);
}
function aQueryTbody($q, $id){
    $r = q_exec($q);
    table_body_only($r, $id);
}
 ?>
