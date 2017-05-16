<?php
require '../datos.php';
session_start();
$user = $_SESSION['user'];
require ROOTDIR.'datos.php';
require ROOTDIR.'server.php';
connect();
print_r($_GET);
$ar1 = '';
$q1 = "SELECT bil_total, bil_name, up_alias, up_op FROM bills INNER JOIN usual_providers ON bil_name = up_name WHERE ";

foreach ($_GET as $key => $value) {
    if(is_integer($key) && $value == 1){
        $ar1 .= "bil_id = $key"." OR ";
    }
}
$periodo = $_GET['lapse'];

$porc = round(porc(), 4);
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

// Crea el array fondos: [n][name/type/def]
$funds = [];
$i = 0;
foreach ($_GET as $key => $value) {
    if(stripos($key, 'name') === 0){
        $funds[$i]['name']= $value;
    }elseif(stripos($key, 'type') === 0){
        $funds[$i]['type']= $value;
    }elseif(stripos($key, 'def') === 0){
        $funds[$i++]['def']= $value;
    }
}

//Se limpian los argumentos
$ar1_2 = substr($ar1, 0, strripos($ar1, "OR"));
$q = $q1.$ar1_2;
$r = q_exec($q);
$bills_ar = query_to_array($r);
//Selecciona los apartamentos y sus pesos ponderados
$q2 = "SELECT A17_number, A17_weight FROM A17";
$r2 = q_exec($q2);
$apts_ar = query_to_array($r2);
//Selecciona el total de los gastos del periodo
$q3 = "SELECT sum(bil_total) AS `total` FROM bills WHERE ".$ar1_2;
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
$porc = round(porc(), 4);

//Se genera el contenido
foreach ($apts_ar as $index => $apt_val) {
    foreach ($bills_ar as $index2 => $bil_val) {
        $content[$apt_val['A17_number']][$bil_val['up_alias']]['nombre'] = $bil_val['up_alias'];
        $content[$apt_val['A17_number']][$bil_val['up_alias']]['porcentaje'] = round($bil_val['bil_total'] * $apt_val['A17_weight'] * $porc /100, 2);
        $content[$apt_val['A17_number']][$bil_val['up_alias']]['total'] = $bil_val['bil_total'];
        //Generar el campo del total a pagar por apartamento
        $sum = 0;
        $sum_total = 0;
        foreach($content[$apt_val['A17_number']] as $apt => $v){
            $sum += $content[$apt_val['A17_number']][$apt]['porcentaje'];
            $sum_total += $content[$apt_val['A17_number']][$apt]['total'];
        }
        $content2[$apt_val['A17_number']]['charged'] = $sum;
        $lastapt = $content[$apt_val['A17_number']];
    }
    //fondos
    foreach ($funds as $key => $value) {
        $valor = numToEng($value['def']);

        if($value['type'] == 1){
            $content[$apt_val['A17_number']][$value['name']]['nombre'] = $value['def'].' %';
            $content[$apt_val['A17_number']][$value['name']]['porcentaje'] = round($sum_total * ($valor /100), 2);
            $content[$apt_val['A17_number']][$value['name']]['total'] = round($sum_total * ($valor / 100), 2);
        }elseif($value['type'] == 2){
            $content[$apt_val['A17_number']][$value['name']]['nombre'] = 'Bs. '.$value['def'];
            $content[$apt_val['A17_number']][$value['name']]['porcentaje'] = round($valor / $actives, 2);
            $content[$apt_val['A17_number']][$value['name']]['total'] = $valor;
        }
        $lastapt = $content[$apt_val['A17_number']];
    }

}
// Nuevo sumario
foreach ($lastapt as $key => $value) {
    $summary2[$key] = $value['total'];
}

$tot = 0;
foreach ($summary2 as $key => $value) {
    $tot += $value;
}

//Se genera la cabecera
$head = ['fecha' => date('d-m-y'), 'Creador' => $user, 'Periodo' => $lap_ar[0]['lap_name'], 'Gen Num' => $fac_number,'Num Aptos' => $actives, 'MCD' => $porc, 'Monto Total' => $tot, 'Balance a la fecha' => ($balance + $tot)];
//print_r($head);

//Se construye el array
$table = [$head, $summary2, $content];

print_r($table);

function porc(){
    $q = "SELECT A17_id, A17_number FROM A17 WHERE A17_assigned = 1";
    $r = q_exec($q);
    $r_asc = query_to_assoc($r);
    $apt_ar = ["large" => 0, "med" => 0, "small" => 0];
    $array = [ "A" => 3, "B" => 2, "C" => 2, "D" => 3, "E" => 2, "F" => 1, "G" => 1, "H" => 2];
    for($i = 0; $i < sizeof($r_asc); $i++){
        $number = $r_asc[$i]['A17_number'];
        $letter = $number[strlen($number) - 1];
        if($letter == "A" || $letter == "D"){
            $apt_ar['large'] += 1;
        }elseif($letter == "B" || $letter == "C" || $letter == "E" || $letter == "H"){
            $apt_ar['med'] += 1;
        }elseif($letter == "F" || $letter == "G"){
            $apt_ar['small'] += 1;
        }
    }
    $large = $apt_ar['large'];
    $med = $apt_ar['med'];
    $small = $apt_ar['small'];
    $part = 100 / (3*$large + 2*$med + $small);
    return $part;
}
 ?>
