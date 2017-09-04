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
            act_name AS 'Actividad',
            bil_desc AS 'Desc.',
            bil_total AS 'Monto'
        FROM {$prx}bills
            INNER JOIN glo_activities ON bil_act_fk = act_id
            INNER JOIN {$prx}habitants ON bil_hab_fk = hab_id
            INNER JOIN {$prx}apartments ON hab_apt_fk = apt_id
        WHERE bil_lapse = :lapse
            AND apt_bui_fk = :bui
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

function getProvidersList($actid){
    $db = connectDb();
    $prx = $db->getPrx();
    $status = false;

    $stmt = $db->prepare(
        "SELECT prov_id AS 'id',
            prov_name AS 'name',
            prov_alias AS 'alias',
            prov_rif AS 'rif'
        FROM {$prx}providers
            INNER JOIN {$prx}skills ON ski_prov_fk = prov_id
            INNER JOIN glo_activities ON ski_act_fk = act_id
        WHERE act_id = :actid"
    );
    $stmt->bindValue('actid', $actid, PDO::PARAM_INT);

    $res= $stmt->execute();

    if(!$res){
        $msg = $stmt->errorInfo()[2];
    }
    else{
        $status = true;
        $msg = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return jsonResponse($status, $msg);
}

function addProviderSkill(/*string*/ $name, /*string*/ $rif, $actid){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();
    $status = false;

    $stmt1 = $db->prepare(
        "INSERT INTO {$prx}providers
        (prov_name,     prov_rif,   prov_sim_fk)
        VALUES
        (:name,         :rif,       :simid)"
    );

    $res = $stmt1->execute(array(
        'name'  => $name,
        'rif'   => $rif? $rif : null,
        'simid' => $simid
    ));

    if(!$res){
        echo $stmt1->errorInfo()[2];
        return false;
    }
    else{
        $stmt2 = $db->prepare(
            "SELECT prov_id
            FROM {$prx}providers
            WHERE prov_name = :name
            ORDER BY prov_id
            LIMIT 1"
        );

        $stmt2->bindValue('name', $name);

        $res2 = $stmt2->execute();

        if(!$res2){
            echo $stmt2->errorInfo()[2];
            return false;
        }
        else{
            $provid = $stmt2->fetchColumn();

            $stmt3 = $db->prepare(
                "INSERT INTO {$prx}skills
                (ski_prov_fk,   ski_act_fk)
                VALUES
                (:provid,       :actid)"
            );
            $stmt3->bindValue('provid', $provid, PDO::PARAM_INT);
            $stmt3->bindValue('actid', $actid, PDO::PARAM_INT);

            $res3 = $stmt3->execute();

            if(!$res3){
                echo $stmt3->errorInfo()[2];
                return false;
            }
            else{
                return $provid;
            }
        }
    }
}

function addBill(/*string*/ $desc, /*string*/ $date, /*int*/ $buiid,
                 /*int*/ $habid, /*int*/ $provid, /*int*/ $accid,
                 /*int*/ $actid, /*string*/ $log, /*float*/ $amount,
                 /*float*/ $iva, /*float*/ $total, $op)
{

    $db = connectDb();
    $prx = $db->getPrx();
    $status = false;

    $stmt1 = $db->prepare(
        "INSERT INTO {$prx}bills
        (bil_desc,      bil_date,   bil_bui_fk, bil_hab_fk,
         bil_prov_fk,   bil_acc_fk, bil_act_fk,
         bil_log,       bil_lapse,  bil_amount, bil_iva,
         bil_total,     bil_op)
        VALUES
        (:desc,         :date,      :buiid,     :habid,
         :provid,       :accid,     :actid,
         :log,          0,          :amount,    :iva,
         :total,        :op)"
    );

    $stmt1->bindValue('desc', $desc);
    $stmt1->bindValue('date', $date);
    $stmt1->bindValue('buiid', $buiid, PDO::PARAM_INT);
    $stmt1->bindValue('habid', $habid, PDO::PARAM_INT);
    $stmt1->bindValue('provid', $provid, PDO::PARAM_INT);
    $stmt1->bindValue('accid', $accid, PDO::PARAM_INT);
    $stmt1->bindValue('actid', $actid, PDO::PARAM_INT);

    $stmt1->bindValue('log', $log);
    $stmt1->bindValue('amount', $amount);
    $stmt1->bindValue('iva', $iva);
    $stmt1->bindValue('total', $total);
    $stmt1->bindValue('op', $op);

    $res1 = $stmt1->execute();

    if(!$res1){
        $msg = $stmt1->errorInfo()[2];
    }
    else{
        $stmt2 = $db->prepare(
            "UPDATE {$prx}accounts
            SET acc_balance = acc_balance - :total
            WHERE acc_id = :accid"
        );

        $stmt2->bindValue('total', $total);
        $stmt2->bindValue('accid', $accid, PDO::PARAM_INT);

        $res2 = $stmt2->execute();

        if(!$res2){
            $msg = $stmt2->errorInfo()[2];
        }
        else{
            $status = true;
            $msg = "Gasto agregado con éxito.";
        }
    }

    return jsonResponse($status, $msg);
}

function getActypesList(){
    $db = connectDb();
    $status = false;

    $stmt = $db->query(
        "SELECT aty_id AS 'id',
            aty_name AS 'name'
        FROM glo_actypes"
    );

    if(!$stmt){
        $msg = $db->errorInfo()[2];

    }
    else{
        $msg = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $status = true;
    }
    return jsonResponse($status, $msg);
}

function getActivitiesList($atyid){
    $db = connectDb();
    $status = false;

    $stmt = $db->prepare(
        "SELECT act_id AS 'id',
            act_name AS 'name'
        FROM glo_activities
            INNER JOIN glo_actypes ON act_aty_fk = aty_id
        WHERE aty_id = :atyid"
    );

    $stmt->bindValue('atyid', $atyid, PDO::PARAM_INT);

    $res = $stmt->execute();

    if(!$res){
        $msg = $stmt->errorInfo()[2];
    }
    else{
        $msg = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $status = true;
    }

    return jsonResponse($status, $msg);
}
