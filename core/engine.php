<?php
//Se construyen los recibos
require '../datos.php';
require '../server.php';

connect();
//Periodo de ejemplo: abril
$periodo = 4;
$fac_number = 1000001;
$user = 'Diego';

$q = "SELECT * FROM lapses WHERE lap_id = '$periodo'";
$rlapse = q_exec($q);
//Selecciona los gastos hechos en el periodo dado
//modificado 4 por '$periodo'
$q1 = "SELECT bil_total, bil_notes, up_alias FROM bills, usual_providers WHERE bil_lapse_fk = '$periodo' AND up_id = bil_type_fk";
$r1 = q_exec($q1);
//Selecciona los apartamentos y sus pesos ponderados
$q2 = "SELECT A17_number, A17_weight FROM A17";
$r2 = q_exec($q2);

//Se extraen los datos de los resultados de las consultas
$lap_ar = query_to_array($rlapse);
$month = $lap_ar[0]['lap_month'];
$year = $lap_ar[0]['lap_year'];
$bills_ar = query_to_array($r1);
$apts_ar = query_to_array($r2);

//No se usa
$cc = sizeof($apts_ar);

//Se genera la cabecera
$head = ['fecha' => '222-22-22', 'Usuario' => $user, 'Periodo' => $lap_ar[0]['lap_name'], 'numero' => $fac_number];
//Se genera el contenido
foreach ($apts_ar as $index => $apt_val) {
    foreach ($bills_ar as $index2 => $bil_val) {
        $content[$apt_val['A17_number']][$bil_val['up_alias']]['nombre'] = $bil_val['up_alias'];
        $content[$apt_val['A17_number']][$bil_val['up_alias']]['porcentaje'] = round($bil_val['bil_total'] * $apt_val['A17_weight'] /100, 2);
        $content[$apt_val['A17_number']][$bil_val['up_alias']]['total'] = $bil_val['bil_total'];
    }
}
//Se construye el array
$table = [$head, $content];
//Se pasa de array a json
$type_json = json_encode($table) or die(json_last_error_msg());
//Se crea el archivo y se guarda
$file = fopen(ROOTDIR.'files/fact-'.$year.'-'.$month.'.json', 'w');
fwrite($file, $type_json);
fclose($file);

 ?>
