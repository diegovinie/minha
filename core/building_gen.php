<?php
//Genera los datos para la tabla A17 y guarda en base de datos.
//Sólo se debe ejecutar una vez
//Construcción dinámica de consultas
session_start();
require '../datos.php';
require '../server.php';
//Verifica que sea ejecutado por el programador
if ($_SESSION['type'] == 3){
    //Esta es copia de la función apartToString en datos.php
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
//Crea un array relacionando las letras con el peso ponderado
$array = [ "A" => 3, "B" => 2, "C" => 2, "D" => 3, "E" => 2, "F" => 1, "G" => 1, "H" => 2];

foreach ($apart as $key => $number) {
    //Ubica la última pocisión en el apartamento (la letra)
    $letter = $number[strlen($number) - 1];
    foreach ($array as $key => $weight) {
        if($letter == $key){
            //Crea el array total que relaciona cada apartamento con su
            //respectivo peso
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
//Construye y limpia la consulta y luego la ejecuta
$a = $q1.$q2;
$q3 = substr($a, 0, strripos($a, ','));
$r = q_exec($q3);
echo "Listo!";
}else{echo "Prohibido.";}
 ?>
