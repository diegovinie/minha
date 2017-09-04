<?php
/* components/bills/router.php
 *
 * Enrutador secundario
 * Se incluye en el enrutador principal
 * Retorna un Controlador
 */

defined('_EXE') or die('No hay acceso');

$basedir = dirname(__FILE__).'/';


// Identificador del 2do parámetro en /{primero}/{segundo}
$route[2] = isset($route[2])? $route[2] : '';


if($route[1] == 'admin' && $route[2] == 'gastos'){

    // Identificador del 3er parámetro en /{primero}/{segundo}/{tercer}
    $route[3] = isset($route[3])? $route[3] : '';

    switch ($route[3]) {
        case '':
            $controller = $basedir .'controllers/index.php';
            break;

        case 'nuevo':
            $controller = $basedir .'controllers/billdialog.php';
            break;

        case 'agregar':
            $controller = $basedir .'controllers/addbill.php';
            break;

        case 'getactivities':
            $controller = $basedir .'controllers/getactivities.php';
            break;

        case 'getproviders':
            $controller = $basedir .'controllers/getproviders.php';
            break;

        default:
            die('sin ruta');
            break;
    }
}
