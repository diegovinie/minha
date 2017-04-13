<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', 'altura');
define('DB_NAME', 'bd_minha');
define('FRAC', 0.4166);

function apartToString(){
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
    $f = implode(',', $apart);
    return $f;
}
 ?>
