<?php
/* models/locales.php
 *
 * Funciones de conversión a unidades locales
 */

function numToEng(/*string*/ $num){
    $num = str_replace(',', '.', $num = str_replace('.', '', $num));
    return floatval($num);
}

function cleanString(/*string*/ $string){

    return preg_replace("/[^a-z0-9_\.]/", '', $string);
}

function nombreEinicial(/*string*/ $string){
    $a = preg_split("/\s+/", $string);
    $s = $a[0] ." " .(isset($a[1])? substr($a[1], 0, 1) ."." : "");
    return $s;
}

function beautifyCI(/*string*/ $ci){
    $a = substr($ci, 0, 1);
    $n = substr($ci, 1);
    return $newCI = $a .'-'.number_format($n, 0, '', '.');
}
