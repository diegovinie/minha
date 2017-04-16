<?php
//Datos para conectarse a la base de datos:
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', 'altura');
define('DB_NAME', 'bd_minha');

//Constante del MCM de los apartamentos de A17:
define('FRAC', 0.4166);

//Directorio raíz para la navegación de PHP:
define('ROOTDIR', dirname(__FILE__).'/');

//Retorna un array con todos los apartamentos de A17
function apartToString(){
    $level = 0;
    $num = 1;
    for($level = 1; $level <= 15; $level++){
        $j = 0;
        $letters = 'ABCDEFGH';
        $a = '';
        $let = '';
        for($j = 0; $j < strlen($letters); $j++){
            $let = $letters[$j];
            $apart[$num] = $level.$let;
            $num++;
        }
    }
    $array_apart = implode(',', $apart);
    return $array_apart;
}

//Recibe un float y lo pasa a notación inglesa, ignora la cantidad de decimales
function numToEng($num){
    $num = str_replace(',', '.', $num = str_replace('.', '', $num));
    return floatval($num);
}
 ?>
