<?php
/* components/finances/models/finances.php
 *
 * Modelo
 * Retorna un json con información para tablas
 */

defined('_EXE') or die('Acceso restringido');

$db = include ROOTDIR.'/models/db.php';
include ROOTDIR.'/models/tables.php';
include ROOTDIR.'/models/modelresponse.php';


function getAccountsForTables($bui){
    global $db;
    $status = false;

    $stmt1 = $db->prepare(
        "SELECT acc_id AS 'id', acc_name AS 'Cuenta',
        user_user AS 'Custodio', bui_apt AS 'Apartamento',
        acc_balance AS 'Monto'
        FROM accounts, users, userdata, buildings
        WHERE acc_user = user_id AND acc_user = udata_user_fk
        AND udata_number_fk = bui_id AND acc_bui = :bui"
    );
    $stmt1->bindValue('bui', $bui);
    $res1 = $stmt1->execute();

    $stmt2 = $db->prepare(
        "SELECT '' AS 'a', 'Total en Cuentas:' AS 'b',
        '' AS 'c', '' AS 'd', SUM(acc_balance) AS 'total'
        FROM accounts
        WHERE acc_bui = :bui"
    );
    $stmt2->bindValue('bui', $bui);
    $res2 = $stmt2->execute();

    if(!$res1 || !$res2){
        // Ha fallado alguna de las consultas.
        $msg = "Error al consultar datos.";
    }
    else{
        $table = setTheadTbodyTfootFromPDO($stmt1, $stmt2);

        if(!$table){
            $msg = 'Error al constuir la tabla';
        }
        else{
            $status = true;
            $msg = $table;
        }
    }

    return jsonTableResponse($status, $msg);
}

function getFundsForTables($bui){
    global $db;
    $status = false;

    $stmt1 = $db->prepare(
        "SELECT fun_id AS 'id', fun_name AS 'Nombre',
        CASE fun_type
        WHEN 1 THEN 'Porcentaje'
        WHEN 2 THEN 'Monto' END AS 'Tipo',
        fun_default AS 'Cuota', fun_balance AS 'Monto'
        FROM funds
        WHERE fun_bui = :bui"
    );
    $stmt1->bindValue('bui', $bui);
    $res1 = $stmt1->execute();

    $stmt2 = $db->prepare(
        "SELECT '' AS 'a', 'Total en Fondos:' AS 'b',
        '' AS 'c', '' AS 'd',
        SUM(fun_balance) AS 'total'
        FROM funds
        WHERE fun_bui = :bui"
    );
    $stmt2->bindValue('bui', $bui);
    $res2 = $stmt2->execute();

    if(!$res1 || !$res2){
        // Ha fallado alguna de las consultas.
        $msg = "Error al consultar datos.";
    }
    else{
        $table = setTheadTbodyTfootFromPDO($stmt1, $stmt2);

        if(!$table){
            $msg = 'Error al constuir la tabla';
        }
        else{
            $status = true;
            $msg = $table;
        }
    }
    return jsonTableResponse($status, $msg);
}

function getMovementsForTables(){
    global $db;
    $status = false;

    $stmt = $db->prepare(

    );

    $res = $stmt->execute();
}

function getAptBalancesForTables($bui){
    global $db;
    $status = false;

    $stmt1 = $db->prepare(
        "SELECT bui_id AS 'id', bui_apt AS 'Apartamento',
        bui_balance AS 'Deuda'
        FROM buildings
        WHERE bui_name = :bui"
    );
    $stmt1->bindValue('bui', $bui);
    $res1 = $stmt1->execute();

    $stmt2 = $db->prepare(
        "SELECT '' AS 'a', 'Deuda Total:' AS 'b',
        SUM(bui_balance) AS 'total'
        FROM buildings
        WHERE bui_name = :bui"
    );
    $stmt2->bindValue('bui', $bui);
    $res2 = $stmt2->execute();

    if(!$res1 || !$res2){
        // Ha fallado alguna de las consultas.
        $msg = "Error al consultar datos.";
    }
    else{
        $table = setTheadTbodyTfootFromPDO($stmt1, $stmt2);

        if(!$table){
            $msg = 'Error al constuir la tabla';
        }
        else{
            $status = true;
            $msg = $table;
        }
    }
    return jsonTableResponse($status, $msg);
}

function getDisponibility(){
    global $db;
    $status = false;

    $stmt = $db->prepare(

    );

    $res = $stmt->execute();
}

function getCurrentBalance($bui){
    global $db;
    $status = false;

    $stmt = $db->prepare(
        "SELECT SUM(bui_balance)
        FROM buildings
        WHERE bui_name = :bui"
    );
    $stmt->bindValue('bui', $bui);
    $res = $stmt->execute();

    if(!$res){
        $msg = "Error al consultar datos.";
    }
    else{
        $status = true;
        $msg = $stmt->fetchColumn();
    }
    return jsonResponse($status, $msg);
}

function getTotalFunds($bui){
    global $db;
    $status = false;

    $stmt = $db->prepare(
        "SELECT SUM(fun_balance)
        FROM funds
        WHERE fun_bui = :bui"
    );
    $stmt->bindValue('bui', $bui);
    $res = $stmt->execute();

    if(!$res){
        $msg = "Error al consultar datos.";
    }
    else{
        $status = true;
        $msg = $stmt->fetchColumn();
    }
    return jsonResponse($status, $msg);
}
