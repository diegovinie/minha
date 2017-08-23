<?php
/* components/invoices/router.php
 *
 * Enrutador secundario
 * Se incluye en el enrutador principal
 * Retorna un Controlador
 */

defined('_EXE') or die('No hay acceso');

$basedir = dirname(__FILE__).'/';


// Identificador del 2do parámetro en /{primero}/{segundo}
$route[2] = isset($route[2])? $route[2] : '';

if($route[1] == 'recibos'){
    switch ($route[2]) {
        // Ruta no identificada
        default:
            die('sin ruta');
            break;
    }
}

if($route[1] == 'admin' && $route[2] == 'recibos'){

    // Identificador del 3er parámetro en /{primero}/{segundo}/{tercer}
    $route[3] = isset($route[3])? $route[3] : '';

    switch ($route[3]) {
        case '':
            $controller = $basedir .'controllers/manage.php';
            break;

        case 'crear':
            $controller = $basedir .'controllers/create.php';
            break;

        default:
            die('sin ruta');
            break;
    }
}
