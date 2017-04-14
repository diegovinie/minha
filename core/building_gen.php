<?php
session_start();
require '../datos.php';
require '../server.php';

if ($_SESSION['type'] == 3){
    $i = 0;
    $k = 1;
    for($i = 1; $i <= 15; $i++){
        $j = 0;
        $letters = 'ABCDEFGH';
        $a = '';
        $b = '';
        for($j = 0; $j < strlen($letters); $j++){
            $b = $letters[$j];
            $apart[$k] = $i.$b;
            $k++;
        }
    }

$array = [ "A" => 3, "B" => 2, "C" => 2, "D" => 3, "E" => 2, "F" => 1, "G" => 1, "H" => 2];

foreach ($apart as $key => $number) {
    $letter = $number[strlen($number) - 1];
    foreach ($array as $key => $weight) {
        if($letter == $key){
            $total[$number] = FRAC * $weight;
        }
    }
}

connect();
$q1 = "INSERT INTO A17 VALUES \n";
$q2 = '';
foreach ($total as $number => $percent) {
    $q2 .= "(NULL, '$number', '$percent', 1, 1, NULL), \n";
}
$a = $q1.$q2;
$q3 = substr($a, 0, strripos($a, ','));
$r = q_exec($q3);
echo "Listo!";
}else{"Prohibido.";}
 ?>
