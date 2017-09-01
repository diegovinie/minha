<?php
/* components/bills/models/bills.php
 *
 * Modelo
 * Retorna un json con información para tablas
 */

defined('_EXE') or die('Acceso restringido');

include_once ROOTDIR.'/models/db.php';
include_once ROOTDIR.'/models/tables.php';
include_once ROOTDIR.'/models/modelresponse.php';

function getBillsByLapse($bui, $lapse){

    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt = $db->prepare(
        "SELECT bil_id AS 'id',
            bil_date AS 'Fecha',
            CONCAT(hab_name, ' ', hab_surname) AS 'Creador',
            bil_class AS 'Clase',
            bil_desc AS 'Desc.',
            bil_total AS 'Monto'
            FROM {$prx}bills,
                {$prx}habitants,
                {$prx}apartments
        WHERE hab_apt_fk = apt_id
            AND bil_hab_fk = hab_id
            AND apt_bui_fk = :bui
            AND bil_lapse = :lapse
            AND bil_bui_fk = :bui
        ORDER BY bil_id DESC"
    );
    $stmt->bindValue('lapse', $lapse, PDO::PARAM_INT);
    $stmt->bindValue('bui', $bui, PDO::PARAM_INT);
    $res = $stmt->execute();

    if(!$res){
        // Ha fallado alguna de las consultas.
        //$msg = "Error al consultar datos.";
        $msg = $stmt->errorInfo()[2]; echo $msg; die;
    }
    else{
        if($stmt->rowCount() == 0){
            $msg = "No hay datos para mostrar.";
        }
        else{
            $table = setTheadTbodyFromPDO($stmt);

            if(!$table){
                $msg = 'Error al construir la tabla';
            }
            else{
                $status = true;
                $msg = $table;
            }
        }
    }

    return jsonTableResponse($status, $msg);
}

function getAccountsList(/*int*/ $buiid){
    $db = connectDb();
    $prx = $db->getPrx();
    $status = false;

    $stmt = $db->prepare(
        "SELECT acc_id AS 'id',
            acc_name AS 'name',
            acc_balance AS 'balance'
        FROM {$prx}accounts
        WHERE acc_bui_fk = :buiid"
    );

    $stmt->bindValue('buiid', $buiid, PDO::PARAM_INT);
    $res = $stmt->execute();

    if(!$res){
        $msg = $stmt->errorInfo()[2];
    }
    else{
        $status = true;
        //var_dump($)
        $msg = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return jsonResponse($status, $msg);
}

function getLapsesList(){
    $db = connectDb();
    $prx = $db->getPrx();
    $status = false;

    $res = $db->query(
        "SELECT lap_id,
            lap_name
        FROM glo_lapses
        ORDER BY lap_id DESC
        LIMIT 5"
    );

    if(!$res){
        $msg = $db->errorInfo()[2];
    }
    else{
        $status = true;
        $msg = $res->fetchAll(PDO::FETCH_ASSOC);
    }

    return jsonResponse($status, $msg);
}

function getProvidersList(){
    $db = connectDb();
    $prx = $db->getPrx();
    $status = false;

    $res = $db->query(
        "SELECT prov_id AS 'id',
            prov_name AS 'name',
            prov_alias AS 'alias',
            prov_rif AS 'rif'
        FROM {$prx}providers"
    );

    if(!$res){
        $msg = $db->errorInfo()[2];
    }
    else{
        $status = true;
        $msg = $res->fetchAll(PDO::FETCH_ASSOC);
    }

    return jsonResponse($status, $msg);
}

function addProvider(/*array*/ $provider){
    $db = connectDb();
    $prx = $db->getPrx();
    $status = false;

    extract($provider);

    $stmt = $db->prepare(
        "INSERT INTO {$prx}providers
        VALUES(
            NULL,
            :name,
            :alias,
            :rif,
            :cel,
            :email)"
    );

    $res = $stmt->execute(array(
        'name'  => $name,
        'alias' => $alias? $alias : null,
        'rif'   => $rif? $rif : null,
        'cel'   => $cel? $cel : null,
        'email' => $email? $email : null
    ));
}

function addBill(/*array*/ $bill){
    $db = connectDb();
    $prx = $db->getPrx();
    $status = false;

    extract($bill);


    $stmt1 = $db->prepare(
        "INSERT INTO {$prx}bills
        VALUES(
            'NULL,
            :desc,
            :date,
            :buiid,
            :habid,
            :prov,
            :acc,
            class,
            :method,
            :log,
            0,
            :amount,
            :iva,
            :total,
            :op')"
    );

    $stmt2 = $db->prepare(
        "UPDATE {$prx}accounts
        SET acc_balance = acc_balance - :total
        WHERE acc_id = :accid"
    );

    $stmt2->bindValue('total', $total);
    $stmt2->bindValue('accid', $accid);
}
