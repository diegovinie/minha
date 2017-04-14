<?php
require '../datos.php';
require '../server.php';

connect();
$periodo = 4;
$q = "SELECT * FROM lapses WHERE lap_id = '$periodo'";
$rr = q_exec($q);

$q1 = "SELECT bil_total, bil_notes, up_alias FROM bills, usual_providers WHERE bil_lapse_fk = 4 AND up_id = bil_type_fk";
$r1 = q_exec($q1);

$q2 = "SELECT A17_number, A17_weight FROM A17";
$r2 = q_exec($q2);

/*
$i = 0;
while($un1 = mysql_fetch_array($r1)){
    foreach ($un1 as $key => $value) {
        $list1[$i][$key] = $value;
    }
    $i++;
}
$i = 0;
while($un2 = mysql_fetch_array($r2)){
    foreach ($un2 as $key => $value) {
        $list2[$i][$key] = $value;
    }
    $i++;
}
*/

$lap = ArrayToJson($rr);
$month = $lap[0]['lap_month'];
$year = $lap[0]['lap_year'];
$a = ArrayToJson($r1);
$b = ArrayToJson($r2);

$c = sizeof($b);

$fac_number = 1000001;
$user = 'Diego';

$head = ['fecha' => '222-22-22', 'Usuario' => $user, 'Periodo' => $lap[0]['lap_name'], 'numero' => $fac_number];

foreach ($b as $index => $array) {
    foreach ($a as $index2 => $array2) {
        $content[$array['A17_number']][$array2['up_alias']]['nombre'] = $array2['up_alias'];
        $content[$array['A17_number']][$array2['up_alias']]['total'] = $array2['bil_total'];
        $content[$array['A17_number']][$array2['up_alias']]['porcentaje'] = round($array2['bil_total'] * $array['A17_weight'] /100, 2);
    }
}

$tabla = [$head, $content];

$type_json = json_encode($tabla) or die(json_last_error_msg());

$file = fopen(ROOTDIR.'files/fact-'.$year.'-'.$month.'.json', 'w');
fwrite($file, $type_json);
fclose($file);

 ?>
