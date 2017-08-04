<?php
/* models/locales.php
 *
 * Funciones de conversión a unidades locales
 */

function numToEng($num){
    $num = str_replace(',', '.', $num = str_replace('.', '', $num));
    return floatval($num);
}
