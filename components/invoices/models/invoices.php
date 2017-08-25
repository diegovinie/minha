<?php
/* components/invoices/models/invoices.php
 *
 * Modelo
 *
 */

defined('_EXE') or die('Acceso restringido');

$db = include ROOTDIR.'/models/db.php';
include ROOTDIR.'/models/modelresponse.php';
include ROOTDIR.'/models/errors.php';
include ROOTDIR.'/models/buildings.php';

/**
 *
 * @return Array|false Registra el error.
 */
function getUserInfo(/*int*/ $id){
    global $db;

    $stmt = $db->prepare(
        "SELECT udata_name AS 'name',
        udata_surname AS 'surname',
        user_user AS 'email'
        FROM userdata INNER JOIN users
        ON user_id = udata_user_fk
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
    global $db;

    $stmt = $db->prepare(
        "SELECT lap_id AS 'id', lap_name AS 'name',
        lap_month AS 'm', lap_year AS 'y'
        FROM lapses
        WHERE lap_id = :lapse"
    );
    $stmt->bindValue('lapse', $lapse, PDO::PARAM_INT);
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
    global $db;

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
    global $db;

    $stmt = $db->prepare(
        "SELECT fun_name AS 'name',
        fun_type AS 'type'
        FROM funds
        WHERE fun_id = :id"
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
    global $db;

    $stmt = $db->prepare(
        "UPDATE bills
        SET bil_lapse_fk = 99
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
    global $db;
    $status = false;

    // Desmarcar los gastos en la base de datos.
    $res = $db->exec(
        "UPDATE bills
        SET bil_lapse_fk = 0
        WHERE bil_lapse_fk = 99"
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
    global $db;

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
    global $db;

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
function getBalanceFromBuildings(/*string*/ $bui){
    global $db;

    $stmt = $db->prepare(
        "SELECT SUM(bui_balance) AS 'balance'
        FROM buildings
        WHERE bui_name = :bui"
    );
    $stmt->bindValue('bui', $bui);
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

    return call_user_func('getFraction'.$bui, $bui);
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
                            /*array*/   $bills,
                            /*array*/   $funds){

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
    $balance = getBalanceFromBuildings($bui);

    $frac =round(getFractionBuilding($bui), 4);

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
                                           $frac/100, 2);

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
        foreach ($aFunds as $fund) {

            $defNum = numToEng($fund['val']);

            if($fund['type'] == 1){

                $content[$apt['name']]
                        [$fund['name']]
                        [$fund['name']]
                        ['nombre'] = $fund['val'].' %';

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
                        ['nombre'] = 'Bs. '.$fund['val'];

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

    $hdr2 = fopen(ROOTDIR."/files/invoices/$bui/LOT-$fNum.json", 'w');

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
        // Recupera el archivo json con la información del lote.
        $fileInvoices = ROOTDIR."/files/invoices/$bui/LOT-$number.json";

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

/**
 * Busca el archivo json del lote y actualiza
 * la base de datos.
 *
 * @return jsonResponse()
 */
function saveInvoicesBatch(/*string*/ $bui, /*int*/ $number){
    global $db;
    $status = false;
    $error = false;

    // Recupera el archivo json con la información del lote.
    $fileInvoices = ROOTDIR."/files/invoices/$bui/LOT-$number.json";

    // Decodifica el lote como un array de objetos.
    $inv = json_decode(include($fileInvoices));

    $lapse = $inv->{'head'}->{'Periodo'};

    $stmt1 = $db->prepare(
        "SELECT lap_id AS 'id'
        FROM lapses
        WHERE lap_name = :lapse"
    );
    $stmt1->bindValue('lapse', $lapse);
    $res1 = $stmt1->execute();

    if(!$res1){
        $msg = "Error al recuperar datos del periodo $lapse";
    }
    else{
        // Agrega a los gastos en cuestión el periodo.
        $lapid = (int)$stmt1->fetchColumn();

        $exe2 = $db->exec(
            "UPDATE bills
            SET bil_lapse_fk = $lapid
            WHERE bil_lapse_fk = 99"
        );

        if(!$exe2){
            $msg = "No se pudo fijar el periodo a los gastos.";
        }
        else{
            // Actualizar la tabla funds.
            $stmt3 = $db->prepare(
                "UPDATE funds
                SET fun_balance = fun_balance + :amount
                WHERE fun_name = :name"
            );
            // fund[0] es el monto, es un array[1]
            $stmt3->bindParam('amount', $fund[0], PDO::PARAM_FLOAT);
            $stmt3->bindParam('name', $name);

            foreach ($inv->{'summary'} as $name => $fund) {
                // Descarta los gastos comunes.
                if($name != 'Comunes'){
                    $exe3 = $stmt3->execute();

                    if(!$exe3){
                        $error = true;
                        $msg = "Error al actualizar el fondo $name.";
                        break;
                    }
                }
            }

            // Se actualiza el balance de cada apartamento
            // restandole el total.
            foreach ($inv->{'charges'} as $apt => $val) {
                $chargues[$apt] = $val->{'total'} ;
            }

            $stmt4 = $db->prepare(
                "UPDATE buildings
                SET bui_balance = bui_balance - :total
                WHERE bui_apt = :apt
                AND bui_name = :bui"
            );
            $stmt4->bindParam('total', $total, PDO::PARAM_FLOAT);
            $stmt4->bindParam('apt', $apt);
            $stmt4->bindValue('bui', $bui);

            foreach ($charges as $apt => $total) {
                $res4 = $stmt->execute();

                if(!$res4){
                    $error = true;
                    $msg = "Error al actualizar apt. $apt.";
                    break;
                }
            }

            if(!$error){
                // Si no hay ningún problema.
                $status = true;
                $msg = "Guardado con éxito.";
            }
        }
    }

    return jsonResponse($status, $msg);
}
