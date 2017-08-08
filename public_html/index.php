<?php
/* public_html/index.php
 *
 * Controlador frontal
 * Punto de entrada de la aplicación
 */

require_once('../settings.php');

define('_EXE', TOKEN);

// Pasa la ruta a string
if(isset($_SERVER['PATH_INFO'])){
    $route = explode('/', $_SERVER['PATH_INFO']) ;
}else{
    $route[1] = '';
}

// El enrutador retorna un controlador
include ROOTDIR.'/router.php';

// Llama al controlador secundario
isset($controller)? include $controller : exit;
