<?php
/* public_html/index.php
 *
 * Controlador frontal
 * Punto de entrada de la aplicación
 */

require_once('../settings.php');

define('_EXE', TOKEN);

// Pasa la ruta a string
$route = explode('/', $_SERVER['PATH_INFO']) ;

// El enrutador retorna un controlador
$contoller = include ROOTDIR.'/router.php';

// Llama al controlador secundario
include $controller;
