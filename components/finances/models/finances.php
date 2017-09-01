<?php
/* components/finances/models/finances.php
 *
 * Modelo
 * Retorna un json con información para tablas
 */

defined('_EXE') or die('Acceso restringido');

include_once ROOTDIR.'/models/db.php';
include_once ROOTDIR.'/models/tables.php';
include_once ROOTDIR.'/models/modelresponse.php';


function getAccountsForTables(/*int*/ $buiid){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt1 = $db->prepare(
        "SELECT acc_id AS 'id',
            acc_name AS 'Cuenta',
            CONCAT(hab_name, ' ', hab_surname) AS 'Custodio',
            apt_name AS 'Apartamento',
            acc_balance AS 'Monto'
        FROM {$prx}accounts
            INNER JOIN {$prx}habitants ON acc_hab_fk = hab_id
            INNER JOIN {$prx}apartments ON hab_apt_fk = apt_id
            INNER JOIN glo_buildings ON acc_bui_fk = bui_id
        WHERE bui_id = :buiid"
    );

    $stmt1->bindValue('buiid', $buiid, PDO::PARAM_INT);
    $res1 = $stmt1->execute();
    //echo $stmt1->errorInfo()[2]; die;

    $stmt2 = $db->prepare(
        "SELECT '' AS 'a',
            'Total en Cuentas:' AS 'b',
            '' AS 'c',
            '' AS 'd',
            SUM(acc_balance) AS 'total'
        FROM {$prx}accounts
            INNER JOIN {$prx}habitants ON acc_hab_fk = hab_id
            INNER JOIN {$prx}apartments ON hab_apt_fk = apt_id
            INNER JOIN glo_buildings ON acc_bui_fk = bui_id
        WHERE bui_id = :buiid"
    );
    
    $stmt2->bindValue('buiid', $buiid, PDO::PARAM_INT);
    $res2 = $stmt2->execute();

    if(!$res1 || !$res2){
        // Ha fallado alguna de las consultas.
        $msg = "Error al consultar datos.";
    }
    else{
        $table = setTheadTbodyTfootFromPDO($stmt1, $stmt2);

        if(!$table){
            $msg = 'Error al construir la tabla';
        }
        else{
            $status = true;
            $msg = $table;
        }
    }

    return jsonTableResponse($status, $msg);
}

function getFundsForTables(/*int*/ $buiid){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt1 = $db->prepare(
        "SELECT fun_id AS 'id',
            fun_name AS 'Nombre',
            CASE fun_type
              WHEN 1 THEN 'Porcentaje'
              WHEN 2 THEN 'Monto' END AS 'Tipo',
            fun_default AS 'Cuota',
            fun_balance AS 'Monto'
        FROM {$prx}funds
            INNER JOIN glo_buildings ON fun_bui_fk = bui_id
        WHERE bui_id = :buiid"
    );

    $stmt1->bindValue('buiid', $buiid, PDO::PARAM_INT);
    $res1 = $stmt1->execute();

    $stmt2 = $db->prepare(
        "SELECT '' AS 'a',
            'Total en Fondos:' AS 'b',
              '' AS 'c',
              '' AS 'd',
              SUM(fun_balance) AS 'total'
        FROM {$prx}funds
            INNER JOIN glo_buildings ON fun_bui_fk = bui_id
        WHERE  bui_id = :buiid"
    );

    $stmt2->bindValue('buiid', $buiid, PDO::PARAM_INT);
    $res2 = $stmt2->execute();

    if(!$res1 || !$res2){
        // Ha fallado alguna de las consultas.
        $msg = "Error al consultar datos.";
    }
    else{
        $table = setTheadTbodyTfootFromPDO($stmt1, $stmt2);

        if(!$table){
            $msg = 'Error al construir la tabla';
        }
        else{
            $status = true;
            $msg = $table;
        }
    }
    return jsonTableResponse($status, $msg);
}

function getMovementsForTables(){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt = $db->prepare(

    );

    $res = $stmt->execute();
}

function getAptBalancesForTables(/*int*/ $buiid){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt1 = $db->prepare(
        "SELECT apt_id AS 'id',
            apt_name AS 'Apartamento',
            COUNT(hab_apt_fk) AS 'Usuarios',
            apt_balance AS 'Deuda'
        FROM {$prx}apartments
            INNER JOIN {$prx}habitants ON hab_apt_fk = apt_id
        WHERE apt_bui_fk = :buiid
        GROUP BY hab_apt_fk"
    );

    $stmt1->bindValue('buiid', $buiid, PDO::PARAM_INT);
    $res1 = $stmt1->execute();
    //echo $stmt1->errorInfo()[2], die,
    $stmt2 = $db->prepare(
        "SELECT '' AS 'a',
            'Deuda Total:' AS 'b',
            SUM(apt_balance) AS 'total'
        FROM {$prx}apartments
        WHERE apt_bui_fk = :buiid"
    );
    $stmt2->bindValue('buiid', $buiid, PDO::PARAM_INT);
    $res2 = $stmt2->execute();

    if(!$res1 || !$res2){
        // Ha fallado alguna de las consultas.
        $msg = "Error al consultar datos.";
    }
    else{
        $table = setTheadTbodyTfootFromPDO($stmt1, $stmt2);

        if(!$table){
            $msg = 'Error al construir la tabla';
        }
        else{
            $status = true;
            $msg = $table;
        }
    }
    return jsonTableResponse($status, $msg);
}

function getDisponibility(){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt = $db->prepare(

    );

    $res = $stmt->execute();
}

function getCurrentBalance(/*int*/ $buiid){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt = $db->prepare(
        "SELECT SUM(apt_balance)
        FROM {$prx}apartments
        WHERE apt_bui_fk = :buiid"
    );

    $stmt->bindValue('buiid', $buiid, PDO::PARAM_INT);
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

function getTotalFunds(/*buiid*/ $buiid){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt = $db->prepare(
        "SELECT SUM(fun_balance)
        FROM {$prx}funds
        WHERE fun_bui_fk = :buiid"
    );
    $stmt->bindValue('buiid', $buiid, PDO::PARAM_INT);
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
