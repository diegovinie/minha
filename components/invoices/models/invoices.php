<?php
/* components/invoices/models/invoices.php
 *
 * Modelo
 *
 */

defined('_EXE') or die('Acceso restringido');

include_once ROOTDIR.'/models/db.php';
include_once ROOTDIR.'/models/modelresponse.php';
include_once ROOTDIR.'/models/errors.php';
include_once ROOTDIR.'/models/buildings.php';

/**
 *
 * @return Array|false Registra el error.
 */
function getUserInfo(/*int*/ $id){
    $db = connectDb();
    $prx = $db->getPrx();

    $stmt = $db->prepare(
        "SELECT hab_name AS 'name',
            hab_surname AS 'surname',
            user_user AS 'email'
        FROM {$prx}habitants
            INNER JOIN glo_users ON hab_user_fk = user_id
        WHERE user_id = :id"
    );
    $stmt->bindValue('id', $id, PDO::PARAM_INT);
    $res = $stmt->execute();

    if(!$res){
        $msg = "Error en recuperar los datos del usuario.";
        errorRegister($msg);

        return false;
    }
    else{
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

/**
 *
 * @return Array|false Registra el error.
 */
function getLapseInfo(/*int*/ $lapse){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();

    $stmt = $db->prepare(
        "SELECT lap_id AS 'id',
            lap_name AS 'name',
            lap_month AS 'm',
            lap_year AS 'y'
        FROM {$prx}lapses
        WHERE lap_id = :lapse
            AND lap_sim_fk = :simid"
    );
    $stmt->bindValue('lapse', $lapse, PDO::PARAM_INT);
    $stmt->bindValue('simid', $simid, PDO::PARAM_INT);
    $res = $stmt->execute();

    if(!$res){
        $msg = "Error en el Periodo.";
        errorRegister($msg);

        return false;
    }
    else{
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

/**
 *
 * @return array[][]|false Registra el error.
 */
function getBillsInfo(/*array*/ $listid){
    $db = connectDb();
    $prx = $db->getPrx();

    if(empty($listid) || !$listid) return false;

    $stmt = $db->prepare(
        "SELECT bil_total AS 'total',
            act_name AS 'actividad',
            aty_name AS 'tipo',
            bil_desc AS 'desc'
        FROM {$prx}bills
            INNER JOIN glo_activities ON bil_act_fk = act_id
            INNER JOIN glo_actypes ON act_aty_fk = aty_id
        WHERE bil_id = :id"
    );
    $stmt->bindParam('id', $id, PDO::PARAM_INT);

    foreach ($listid as $id) {
        $res = $stmt->execute();

        if(!$res){
            $msg = 'Algunos gastos no fueron correctamente seleccionados.';
            errorRegister($msg);

            return false;
        }
        else{
            $data[] = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    return $data;
}

/**
 *
 * @return array[][]|false Registra el error.
 */
function getFundsInfo(/*array*/ $listid){
    $db = connectDb();
    $prx = $db->getPrx();

    if(empty($listid) || !$listid) return false;

    $stmt = $db->prepare(
        "SELECT acc_name AS 'name',
            acc_op AS 'type'
        FROM {$prx}accounts
            INNER JOIN glo_types s ON acc_type_fk = s.type_id
            INNER JOIN glo_types d ON s.type_ref = d.type_id
        WHERE acc_id = :id
            AND s.type_name = 'fondo'"
    );
    $stmt->bindParam('id', $id, PDO::PARAM_INT);

    foreach ($listid as $id => $f) {
        $res = $stmt->execute();

        if(!$res){
            $msg = 'Algunos fondos no fueron correctamente seleccionados.';
            errorRegister($msg);

            return false;
        }
        else{
            $prep = $stmt->fetch(PDO::FETCH_ASSOC);
            $prep['val'] = $f['val'];
            $data[] = $prep;
        }
    }

    return $data;
}

/**
 *
 * @return bool / Registra el error.
 */
function setBillsQueue(/*array*/ $listid){
    $db = connectDb();
    $prx = $db->getPrx();

    $stmt = $db->prepare(
        "UPDATE {$prx}bills
        SET bil_lapse = NULL
        WHERE bil_id = :id"
    );
    $stmt->bindParam('id', $id, PDO::PARAM_INT);

    foreach ($listid as $id) {
        $res = $stmt->execute();

        if(!$res){
            $msg = 'Algunos gastos no fueron correctamente actualizados.';
            errorRegister($msg);

            return false;
        }
    }
    return true;
}

/**
 *
 * @return bool / Registra el error.
 */
function unsetBillsQueue(){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    // Desmarcar los gastos en la base de datos.
    $res = $db->exec(
        "UPDATE {$prx}bills
        SET bil_lapse = 0
        WHERE bil_lapse IS NULL"
    );

    if(!$res){
        $msg = "Problemas para desmarcar los gastos.";
        errorRegister($msg);

        return false;
    }

    return true;
}

/**
 *
 * @return array[][]|false Registra el error.
 */
function getAssignedApts(/*string*/ $bui){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();

    $stmt = $db->prepare(
        "SELECT apt_name AS 'name',
            apt_weight AS 'w',
            apt_balance AS 'balance'
        FROM {$prx}apartments
        WHERE apt_assigned = 1
            AND apt_sim_fk = :simid
            AND apt_edf = :bui"
    );
    $stmt->bindValue('bui', $bui);
    $stmt->bindValue('simid', $simid, PDO::PARAM_INT);
    $res = $stmt->execute();

    if(!$res){
        $msg = 'Error al seleccionar apartamentos.';
        errorRegister($msg);

        return false;
    }
    else{
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

/**
 *
 * @return integer|false Registra el error.
 */
function getNumberApts(/*string*/ $bui){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();

    $stmt = $db->prepare(
        "SELECT COUNT(apt_id) AS `asignados`
        FROM {$prx}apartments
        WHERE apt_sim_fk = :simid
            AND apt_edf = :bui
            AND apt_assigned = 1"
    );
    $stmt->bindValue('bui', $bui);
    $stmt->bindValue('simid', $simid, PDO::PARAM_INT);
    $res = $stmt->execute();

    if(!$res){
        echo $msg = 'Error al seleccionar el total de apartamentos';
        errorRegister($msg);

        return false;
    }
    else{

        return (int)$stmt->fetchColumn();
    }
}

/**
 *
 * @return float | false Registra el error.
 */
function getBalanceFromApartments(/*string*/ $bui){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();

    $stmt = $db->prepare(
        "SELECT SUM(apt_balance) AS 'balance'
        FROM {$prx}apartments
        WHERE apt_edf = :bui
        AND apt_sim_fk = :simid"
    );
    $stmt->bindValue('bui', $bui);
    $stmt->bindValue('simid', $simid, PDO::PARAM_INT);
    $res = $stmt->execute();

    if(!$res){
        $msg = 'Error al recuperar el balance total.';
        errorRegister($msg);

        return false;
    }
    else{
        return (float)$stmt->fetchColumn();
    }
}

/**
 * @return float | false
 */
function getFractionBuilding(/*string*/ $bui){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();

    $stmt = $db->prepare(
        "SELECT SUM(apt_weight)
        FROM {$prx}apartments
        WHERE apt_sim_fk = :simid
            AND apt_edf = :bui
            AND apt_assigned = 1"
    );

    $stmt->bindValue('simid', $simid, PDO::PARAM_INT);
    $stmt->bindValue('bui', $bui);

    $res = $stmt->execute();

    if(!$res){
        echo $stmt->errorInfo()[2];
        die;

    }
    else{
        echo $total = (float)$stmt->fetchColumn();

        return $total;
    }
}

/**
 * Marca los gastos como en espera (99) en la BD
 * Crea un array del lote de recibos y lo guarda como
 * json en /files/invoices/
 *
 * @return jsonResponse((bool)status, (mix)msg)
 */
function generateInvoicesBatch(  /*int*/  $userid,
                            /*string*/  $bui,
                            /*int*/     $lapse,
                            /*array*/   $bills=null,
                            /*array*/   $funds=null){

    $sumPer = 0;
    $sumTotal = 0;

    $aUser = getUserInfo($userid);

    $aLapse = getLapseInfo($lapse);

    // Para que el mes siempre tenga 2 digitos
    $month = $aLapse['m'] <= 10? '0'.$aLapse['m'] : $aLapse['m'];
    // Se une mes y aǹo para el num de rec
    $fNum = $aLapse['y'].$month;

    // Selecciona la información de los gastos hechos que se seleccionaron
    $aBills = getBillsInfo($bills);

    $aFunds = getFundsInfo($funds);

    // Selecciona los apartamentos y sus pesos ponderados
    $aApts = getAssignedApts($bui);

    //Selecciona la cantidad de apartamentos contribuyentes
    $actives = getNumberApts($bui);

    //Selecciona el balance previo a la generación
    $balance = getBalanceFromApartments($bui);

    $frac = round(getFractionBuilding($bui), 4);

    //Se genera el contenido por apartamento
    foreach ($aApts as $index => $apt) {
        // Cada uno de los gastos
        if($aBills){
            foreach ($aBills as $inB => $bill) {

                $content[$apt['name']]      // Cada apartamento
                        ['Comunes']
                        [$bill['tipo']]     // Cada tipo de actividad
                        [] = array(
                            'actividad' => $bill['actividad'],
                            'nombre'    => $bill['desc'],
                            'alic'      => round($bill['total']
                                                *($apt['w']/$frac), 2),
                            'total'     => round($bill['total'], 2)
                        );


                //Generar el campo del total a pagar por apartamento
                $sumPer = 0;
                $sumTotal = 0;

                foreach ($content[$apt['name']]['Comunes'] as $type) {

                    foreach ($type as $val) {
                        $sumPer += $val['alic'];
                        $sumTotal += $val['total'];
                    }
                }

                $charges[$apt['name']]
                        ['previo'] = -$apt['balance'];

                $charges[$apt['name']]
                        ['actual'] = $sumPer;

                $charges[$apt['name']]
                        ['total'] = $sumPer -$apt['balance'];
            }
        }

        // Se agrega el contenido de los fondos
        if($aFunds){
            foreach ($aFunds as $fund) {

                $defNum = numToEng($fund['val']);

                if($fund['type'] == 1){         // Si es porcentual

                    $content[$apt['name']]      // Cada apartamento
                            ['Fondos']
                            [$fund['name']]     // Cada fondo
                            [] = array(
                                'nombre' => $fund['val'].' %',
                                'alic' => round($sumPer * $defNum /100, 2),
                                'total' => round($sumTotal * ($defNum / 100), 2)
                            );

                }
                elseif($fund['type'] == 2){     // Si es monto fijo

                    $content[$apt['name']]
                            ['Fondos']
                            [$fund['name']]
                            [] = array(
                                'nombre'    => 'Bs. '.$fund['val'],
                                'alic' => round($defNum / $actives, 2),
                                'total'     => $defNum
                            );
                }
            }
        }

        // El contenido del último apartamento para hacer el sumario
        $lastApt = $content[$apt['name']];
    }

    $total = 0;
    // Se genera el nuevo sumario
    foreach ($lastApt as $cat => $combo) {

        foreach($combo as $type => $group){

            $summary[$cat][$type] = 0;

            foreach ($group as $item) {     // Suma cada item de un mismo tipo

                $summary[$cat]
                        [$type] += $item['total'];

                $total += $item['total'];   // Suma al gran total
            }
        }
    }

    // Se busca el nombre completo del edificio
    $hdr = fopen(ROOTDIR."/files/EDI-$bui.json", 'r');
    $f = '';
    while(!feof($hdr)){
        $f .= fgets($hdr);
    }

    $json = json_decode($f);
    $edif = $json->name;

    // Se genera la cabecera
    $head = array(
            'Fecha' => date('d-m-Y'),
            'Creador' => "{$aUser['name']} {$aUser['surname']}",
            'Correo-e' => $aUser['email'],
            'Periodo' => $aLapse['name'],
            'Inmueble' => $edif,
            'Gen Num' => $fNum,
            'Num Aptos' => $actives,
            'MCD' => $frac,
            'Monto Total' => $total,
            'Balance a la fecha' => ($balance + $total)
    );

    //Se construye el array final
    $invoices = array(
            'head'    => $head,
            'summary' => $summary,
            'content' => $content,
            'charges' => $charges
    );

    //Graba contenidos temporales de lo que se va a grabar en charges
    $tj = json_encode($invoices);

    $db = connectDb();
    $prx = $db->getPrx();

    $dirPath = ROOTDIR."/files/{$prx}invoices/$bui";

    if(!is_dir($dirPath)) mkdir($dirPath, 0777, true);

    $hdr2 = fopen($dirPath."/LOT-$fNum.json", 'w');

    fwrite($hdr2, $tj);
    fclose($hdr2);

    // Se marcan los gastos en espera.
    $res = setBillsQueue($bills);

    return checkErrorsResponse(
        $invoices,
        array(  'discardInvoicesBatch',
                $bui,
                $fNum
        )
    );
}

/**
 * Busca el archivo json del lote y borra.
 * También desmarca los gastos en la base de datos.
 *
 * @return jsonResponse()
 */
function discardInvoicesBatch(/*string*/ $bui, /*int*/ $number){
    $status = false;


    $res = unsetBillsQueue();

    if(!$res){
        $msg = "Problemas para desmarcar los gastos.";
    }
    else{
        $db = connectDb();
        $prx = $db->getPrx();

        $dirPath = ROOTDIR."/files/{$prx}invoices/$bui";

        // Recupera el archivo json con la información del lote.
        $fileInvoices = $dirPath."/LOT-$number.json";

        if(!is_file($fileInvoices)){

            $msg = "No se encontró el lote LOT-$number.";
        }
        else{
            // Borra el archivo del lote.
            unlink($fileInvoices);
            $status = true;
            $msg = "Lote LOT-$number borrado con éxito.";
        }
    }

    return jsonResponse($status, $msg);
}
