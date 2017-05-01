<?php
//Se construyen los recibos
session_start();
require '../datos.php';
require '../server.php';
connect();

$user = $_SESSION['user'];
extract($_GET);
switch ($fun) {
    case 'generate':
        print_r ($fun($user, $lapse));
        break;
    case 'save_fact':
        print_r($fun($number));
        break;
    case 'discard':
        print_r($fun($number));
        break;
    default:
        echo "Error";
        break;
}

function generate($user, $periodo){
    //Seleciona los datos del periodo
    $q = "SELECT * FROM lapses WHERE lap_id = '$periodo'";
    $rlapse = q_exec($q);
    $lap_ar = query_to_array($rlapse);
    $month = $lap_ar[0]['lap_month'];
    $year = $lap_ar[0]['lap_year'];
    if($month <= 10){
        $mo = '0'.$month;
    }else{
        $mo = ''.$month;
    }
    $fac_number = $year.$mo;

    //Selecciona los gastos hechos en el periodo dado
    //modificado 4 por '$periodo'
    $q1 = "SELECT bil_total, bil_notes, up_alias FROM bills, usual_providers WHERE bil_lapse_fk = '$periodo' AND up_id = bil_type_fk";
    $r1 = q_exec($q1);
    $bills_ar = query_to_array($r1);
    //Selecciona los apartamentos y sus pesos ponderados
    $q2 = "SELECT A17_number, A17_weight FROM A17";
    $r2 = q_exec($q2);
    $apts_ar = query_to_array($r2);
    //Selecciona el total de los gastos del periodo
    $q3 = "SELECT sum(bil_total) AS `total` FROM bills WHERE bil_lapse_fk = $periodo";
    $r3 = q_exec($q3);
    $tot_ar = query_to_array($r3);
    $tot = $tot_ar[0]['total'];
    //Selecciona la cantidad de apartamentos contribuyentes
    $q4 = "SELECT COUNT(A17_id) AS `asignados` FROM A17 WHERE A17_assigned = 1";
    $r4 = q_exec($q4);
    $actives_ar = query_to_array($r4);
    $actives = $actives_ar[0]['asignados'];
    //Selecciona el balance previo a la generación
    $q5 = "SELECT SUM(cha_amount) AS `balance` FROM charges";
    $r5 = q_exec($q5);
    $bal_ar = query_to_array($r5);
    $balance = $bal_ar[0]['balance'];

    //No se usa
    $cc = sizeof($apts_ar);

    //Se genera la cabecera
    $head = ['fecha' => '222-22-22', 'Creador' => $user, 'Periodo' => $lap_ar[0]['lap_name'], 'Gen Num' => $fac_number,'Num Aptos' => $actives, 'Monto Total' => $tot, 'Balance a la fecha' => ($balance + $tot)];
    //print_r($head);

    //Se genera el resumen
    $summary = [];
    foreach ($bills_ar as $key => $value) {
        $summary[$value['up_alias']] = $value['bil_total'];
    }

    //Se genera el contenido
    foreach ($apts_ar as $index => $apt_val) {
        foreach ($bills_ar as $index2 => $bil_val) {
            $content[$apt_val['A17_number']][$bil_val['up_alias']]['nombre'] = $bil_val['up_alias'];
            $content[$apt_val['A17_number']][$bil_val['up_alias']]['porcentaje'] = round($bil_val['bil_total'] * $apt_val['A17_weight'] /100, 2);
            $content[$apt_val['A17_number']][$bil_val['up_alias']]['total'] = $bil_val['bil_total'];
            //Generar el campo del total a pagar por apartamento
            $sum = 0;
            foreach($content[$apt_val['A17_number']] as $apt => $v){
                $sum += $content[$apt_val['A17_number']][$apt]['porcentaje'];
            }
            $content2[$apt_val['A17_number']]['charged'] = $sum;
        }
    }

    //Se construye el array
    $table = [$head, $summary, $content];

    //Graba contenidos temporales de lo que se va a grabar en charges
    $charges_json = json_encode($content2) or die(json_last_error_msg());
    $file_cha = fopen(ROOTDIR.'files/tmp/charges'.$fac_number.'.json', 'w');
    fwrite($file_cha, $charges_json);
    fclose($file_cha);

    //Se pasa de array a json
    $type_json = json_encode($table) or die(json_last_error_msg());
    //Se crea el archivo y se guarda
    //$file = fopen(ROOTDIR.'files/fact-'.$year.'-'.$month.'.json', 'w');
    $file = fopen(ROOTDIR.'files/fact-'.$fac_number.'.json', 'w');
    fwrite($file, $type_json);
    fclose($file);
    return json_encode([$head, $summary]);
}

function save_fact($fac_number){
    //Graba los datos temporales en charges
    $file = fopen(ROOTDIR.'files/tmp/charges'.$fac_number.'.json', "r");
    $b = fgets($file);
    $c = json_decode($b);
    //print_r($c);

    foreach ($c as $apto => $value) {
        $charg[$apto] = $value->{'charged'};
    }
    //Se insertan los datos en charges y se actualiza A17_balance
    foreach($charg as $apt => $total){
        //Se separa el select para evitar conflictos con el trigger
        $qnum = "SELECT A17_id FROM A17 WHERE A17_number = '$apt'";
        $rnum = mysql_fetch_array(q_exec($qnum));
        $qcharges = "INSERT INTO charges VALUES (NULL, $rnum[0] , $total, NULL, 'diego')\n";
    //    $rcharges = q_exec($qcharges);
    }
    return "Guardado con éxito";
}

function discard($fac_number){
    //elimina los datos temporales y la factura. json
    if(file_exists(ROOTDIR.'files/fact-'.$fac_number.'.json') && file_exists(ROOTDIR.'files/tmp/charges'.$fac_number.'.json')) {
        unlink(ROOTDIR.'files/fact-'.$fac_number.'.json');
        unlink(ROOTDIR.'files/tmp/charges'.$fac_number.'.json');
        $resp = "borrado";
    }else{
        $resp = "no se encuentra";
    }
    return $resp;
}
 ?>
