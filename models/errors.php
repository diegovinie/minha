<?php
/* models/errors.php
 *
 */

defined('_EXE') or die('Acceso restringido');

function errorRegister(/*string*/ $message, /*int*/ $option=0){
    global $_globals;
    //ini_set("log_errors", 1);
    ini_set("error_log", VARDIR.'error-'.TOKEN.'.log');
    error_log($message, $option);

    if(!isset($_globals['errors'])) $_globals['errors'] = 0;
    $_globals['errors'] ++;
    //var_dump($GLOBALS);
}
