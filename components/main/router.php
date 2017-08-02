<?php
/* components/main/router.php
 *
 * Enrutador secundario
 * Se incluye en el enrutador principal
 * Retorna un Controlador
 */

defined('_EXE') or die('No hay acceso');

$basedir = dirname(__FILE__).'/';

// Identificador del 2do parámetro en /{primero}/{segundo}
$route[2] = isset($route[2])? $route[2] : '';

// Enrutador de /main/{opcion}
if($route[1] == 'main'){
    switch ($route[2]) {
        //
        case '':
            //$controller = $basedir .'controllers/login.php';
            break;
        //
        case 'balance':
            $controller = $basedir .'controllers/balance.php';
            break;

        // Ruta no identificada
        default:
            die('sin ruta');
            break;
    }
}
