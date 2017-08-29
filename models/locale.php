<?php
/* models/locales.php
 *
 * Funciones de conversión a unidades locales
 */

function numToEng($num){
    $num = str_replace(',', '.', $num = str_replace('.', '', $num));
    return floatval($num);
}

function cleanString($string){

    return preg_replace("/[^a-z0-9_\.]/", '', $string);
}
