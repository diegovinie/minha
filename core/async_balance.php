<?php
// Controlador: js/balance.js
// Vista: admin/balance.php

session_start();
require_once '../datos.php';
require_once ROOTDIR.'/server.php';
require_once ROOTDIR.'/core/functions.php';
connect();

if(isset($_GET['fun'])){
    extract($_GET);
    $bui = $_SESSION['bui'];
    switch ($arg) {
        case 'balance_apartamentos':
            $q = "SELECT bui_id AS 'id', bui_apt AS 'Apartamento',
            bui_balance AS 'Deuda' FROM buildings WHERE bui_name = '$bui'";
            $q_foot = "SELECT '' AS 'a', 'Deuda Total:' AS 'b',
            SUM(bui_balance) AS 'total' FROM buildings WHERE bui_name = '$bui'";
            break;
        case 'cuentas':
            $q = "SELECT acc_id AS 'id', acc_name AS 'Cuenta',
            user_user AS 'Custodio', bui_apt AS 'Apartamento',
            acc_balance AS 'Monto' FROM accounts, users, userdata, buildings WHERE acc_user = user_id AND acc_user = udata_user_fk
            AND udata_number_fk = bui_id AND acc_bui = '$bui'";
            $q_foot = "SELECT '' AS 'a', 'Total en Cuentas:' AS 'b', '' AS 'c',
            '' AS 'd', SUM(acc_balance) AS 'total' FROM accounts WHERE acc_bui = '$bui'";
            break;
        case 'fondos':
            $q = "SELECT fun_id AS 'id', fun_name AS 'Nombre', CASE fun_type
            WHEN 1 THEN 'Porcentaje' WHEN 2 THEN 'Monto' END AS 'Tipo', fun_default AS 'Cuota', fun_balance AS 'Monto' FROM funds WHERE fun_bui = '$bui' ";
            $q_foot = "SELECT '' AS 'a', 'Total en Fondos:' AS 'b', '' AS 'c',
            '' AS 'd', SUM(fun_balance) AS 'total' FROM funds WHERE fun_bui = '$bui'";
            break;
        case 'apartamento':
            $q = "SELECT bui_apt AS `Apto`, bui_balance AS `Deuda`,
                bui_assigned AS `Asignado`, bui_occupied AS 'Ocupado' FROM buildings WHERE
                bui_id = '$id'";
            break;
        case 'corriente':
            $sq = "SELECT SUM(bui_balance) AS 'a' FROM buildings WHERE bui_name = '$bui'";
            break;
        case 'total_fondos':
            $sq = "SELECT SUM(fun_balance) FROM funds WHERE fun_bui = '$bui'";
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
