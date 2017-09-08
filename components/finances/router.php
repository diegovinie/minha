<?php
/* components/finances/router.php
 *
 * Enrutador secundario
 * Se incluye en el enrutador principal
 * Retorna un Controlador
 */

defined('_EXE') or die('No hay acceso');

$basedir = dirname(__FILE__).'/';


// Identificador del 2do parámetro en /{primero}/{segundo}
$route[2] = isset($route[2])? $route[2] : '';

// Enrutador de /login/{opcion}
/*

    }
}*/

if($route[1] == 'admin' && $route[2] == 'finanzas'){

    // Identificador del 3er parámetro en /{primero}/{segundo}/{tercer}
    $route[3] = isset($route[3])? $route[3] : '';

    switch ($route[3]) {
        case '':
            $controller = $basedir .'controllers/finances.php';
            break;

        case 'nuevacuenta':
            $controller = $basedir. 'controllers/addaccount.php';
            break;    
        /*
        case 'getcurrentmonth':
            $controller = $basedir .'controllers/getcurrentmonth.php';
            break;

        case 'getlastmonth':
            $controller = $basedir .'controllers/getlastmonth.php';
            break;

        case 'getlastthreemonths':
            $controller = $basedir .'controllers/getlastthreemonths.php';
            break;

        case 'approvedpayments':
            $controller = $basedir .'controllers/approvedpayments.php';
            break;
        case 'refusedpayments':
            $controller = $basedir .'controllers/refusedpayments.php';
            break;
        case 'pendingpayments':
            $controller = $basedir .'controllers/pendingpayments.php';
            break;
        */
        default:
            die('sin ruta');
            break;
    }
}
