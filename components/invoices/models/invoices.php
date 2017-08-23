<?php
/* components/invoices/models/invoices.php
 *
 * Modelo
 *
 */

defined('_EXE') or die('Acceso restringido');

$db = include ROOTDIR.'/models/db.php';
include ROOTDIR.'/models/modelresponse.php';

function getLapseInfo(/*int*/ $lapse){
    global $db;
    $status = false;

    $stmt = $db->prepare(
        "SELECT lap_id AS 'id', lap_name AS 'name',
        lap_month AS 'm', lap_year AS 'y'
        FROM lapses
        WHERE lap_id = :lapse"
    );
    $stmt->bindValue('lapse', $lapse, PDO::PARAM_INT);
    $res = $stmt->execute();

    if(!$res){

    }
    else{
        $status = true;
        $msg = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return jsonResponse($status, $msg);
}

function getBillsInfo(/*array*/ $listid){
    global $db;
    $status = false;
    $error = false;

    $stmt = $db->prepare(
        "SELECT bil_total AS 'total', bil_class AS 'class',
        bil_desc AS 'desc'
        FROM bills
        WHERE bil_id = :id"
    );
    $stmt->bindParam('id', $id, PDO::PARAM_INT);

    foreach ($listid as $id) {
        $res = $stmt->execute();

        if(!$res){
            $error = true;
            $msg = 'Algunos gastos no fueron correctamente seleccionados.';
            break;
        }
        else{
            $data[] = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    if(!$error){
        $status = true;
        $msg = $data;
    }
    return jsonResponse($status, $msg);
}

function setBillsQueue(/*array*/ $listid){
    global $db;
    $status = false;
    $error = false;

    $stmt = $db->prepare(
        "UPDATE bills
        SET bil_lapse_fk = 99
        WHERE bil_id = :id"
    );
    $stmt->bindParam('id', $id, PDO::PARAM_INT);

    foreach ($listid as $id) {
        $res = $stmt->execute();

        if(!$res){
            $error = true;
            $msg = 'Algunos gastos no fueron correctamente actualizados.';
            break;
        }
    }

    if(!$error){
        $status = true;
        $msg = 'Todos los gastos actualizados con éxito.';
    }
    return jsonResponse($status, $msg);
}

function getAssignedApts(/*string*/ $bui){
    global $db;
    $status = false;

    $stmt = $db->prepare(
        "SELECT bui_apt AS 'name', bui_weight AS 'w',
        bui_balance AS 'balance'
        FROM buildings
        WHERE bui_assigned = 1
        AND bui_name = :bui"
    );
    $stmt->bindValue('bui', $bui);
    $res = $stmt->execute();

    if(!$res){
        $msg = 'Error al seleccionar apartamentos.';
    }
    else{
        $status = true;
        $msg = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return jsonResponse($status, $msg);
}

function getNumberApts(/*string*/ $bui){
    global $db;
    $status =false;

    $stmt = $db->prepare(
        "SELECT COUNT(bui_id) AS `asignados`
        FROM buildings
        WHERE bui_assigned = 1
        AND bui_name = :bui"
    );
    $stmt->bindValue('bui', $bui);
    $res = $stmt->execute();

    if(!$res){
        $msg = 'Error al seleccionar el total de apartamentos';
    }
    else{
        $status = true;
        $msg = (int)$stmt->fetchColumn();
    }

    return jsonResponse($status, $msg);
}

function getBalanceFromBuildings(/*string*/ $bui){
    global $db;
    $status =false;

    $stmt = $db->prepare(
        "SELECT SUM(bui_balance) AS 'balance'
        FROM buildings
        WHERE bui_name = :bui"
    );
    $stmt->bindValue('bui', $bui);
    $res = $stmt->execute();

    if(!$res){
        $msg = 'Error al recuperar el balance total.';
    }
    else{
        $status = true;
        $msg = (float)$stmt->fetchColumn();
    }

    return jsonResponse($status, $msg);
}

function generateInvoices(  /*string*/  $user,
                            /*string*/  $bui,
                            /*int*/     $lapse,
                            /*array*/   $bills,
                            /*array*/   $funds){

    $aLapse = getLapseInfo($lapse);

    // Para que el mes siempre tenga 2 digitos
    $month = $aLapse['m'] <= 10? '0'.$aLapse['m'] : $aLapse['m'];
    // Se une mes y aǹo para el num de rec
    $fNum = $aLapse['y'].$month;

    // Selecciona la información de los gastos hechos que se seleccionaron
    $aBills = getBillsInfo($bills);

    $res = setBillsQueue($bills);

    // Selecciona los apartamentos y sus pesos ponderados
    $aApts = getAssignedApts($bui);

    //Selecciona la cantidad de apartamentos contribuyentes
    $actives = getNumberApts($bui);

    //Selecciona el balance previo a la generación
    $balance = getBalanceFromBuildings($bui);

    $porc =round(porc($bui), 4);

    //Se genera el contenido por apartamento
    foreach ($aApts as $index => $apt) {
        // Cada uno de los gastos
        foreach ($aBills as $inB => $bill) {

            $content[$apt['name']]
                    ['Comunes']
                    [$inB]
                    ['nombre'] = $bill['class']
                                 .' - ' .$bill['desc'];

            $content[$apt['name']]
                    ['Comunes']
                    [$inB]
                    ['porcentaje'] = round($bill['total'] *
                                           $apt['w'] *
                                           $porc/100, 2);

            $content[$apt['name']]
                    ['Comunes']
                    [$inB]
                    ['total'] = round($bill['total'], 2);

            //Generar el campo del total a pagar por apartamento
            $sumPer = 0;
            $sumTotal = 0;

            foreach ($content[$apt['name']]['Comunes'] as $val) {

                $sumPer += $val['porcentaje'];
                $sumTotal += $val['total'];
            }

            $charges[$apt['name']]
                    ['previo'] = -$apt['balance'];

            $charges[$apt['name']]
                    ['actual'] = $sumPer;

            $charges[$apt['name']]
                    ['total'] = $sumPer -$apt['balance'];
        }

        // Se agrega el contenido de los fondos
        foreach ($funds as $fund) {

            $defNum = numToEng($fund['def']);

            if($fund['type'] == 1){

                $content[$apt['name']]
                        [$fund['name']]
                        [$fund['name']]
                        ['nombre'] = $fund['def'].' %';

                $content[$apt['name']]
                        [$fund['name']]
                        [$fund['name']]
                        ['porcentaje'] = round($sumPer * $defNum /100, 2);

                $content[$apt['name']]
                        [$fund['name']]
                        [$fund['name']]
                        ['total'] = round($sumTotal * ($defNum / 100), 2);
            }
            elseif($fund['type'] == 2){

                $content[$apt['name']]
                        [$fund['name']]
                        [$fund['name']]
                        ['nombre'] = 'Bs. '.$fund['def'];

                $content[$apt['name']]
                        [$fund['name']]
                        [$fund['name']]
                        ['porcentaje'] = round($defNum / $actives, 2);

                $content[$apt['name']]
                        [$fund['name']]
                        [$fund['name']]
                        ['total'] = $defNum;
            }
        }

        // El contenido del último apartamento para hacer el sumario
        $lastApt = $content[$apt['name']];
    }

    // Se genera el nuevo sumario
    foreach ($lastApt as $cat => $dat) {

        foreach($dat as $item){

            $summary[$cat]
                    [$item['nombre']] = $item['total'];
        }
    }

    $total = 0;
    foreach ($summary as $categorie) {
        foreach ($categorie as $value) {
            $total += $value;
        }
    }

    $hdr = fopen(ROOTDIR."/files/EDI-$bui.json", 'r');

    $f = '';
    while(!feof($hdr)){
        $f .= fgets($hdr);
    }

    $json = json_decode($f);
    $edif = $json->name;

    $head = array(
            'fecha' => date('d-m-y'),
            'Creador' => $user,
            'Periodo' => $aLapse['name'],
            'Inmueble' => $edif,
            'Gen Num' => $fNum,
            'Num Aptos' => $actives,
            'MCD' => $porc,
            'Monto Total' => $total,
            'Balance a la fecha' => ($balance + $total)
    );

    $invoices = array(
            'head' => $head,
            'summary' => $summary,
            'content' => $content,
            'charges' => $charges
    );

    $tj = json_encode($invoices);

    $hdr2 = fopen(ROOTDIR."/files/invoices/$bui/FAC-$fNum.json", 'w');

    fwrite($hdr2, $tj);
    fclose($hrd2);

    return $invoices;
}
