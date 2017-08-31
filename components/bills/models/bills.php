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
