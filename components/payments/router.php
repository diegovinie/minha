<?php
/* components/payments/router.php
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
if($route[1] == 'payments'){
    switch ($route[2]) {
        // Página de inicio
        case '':
            $controller = $basedir .'controllers/index.php';
            break;
        // Abrir la ventana de agregar un pago
        case 'add':
            $controller = $basedir .'controllers/addpayment.php';
            break;

        case 'getpayments':
            $controller = $basedir .'controllers/getpayments.php';
            break;

        case 'getpendingpayments':
            $controller = $basedir .'controllers/getpendingpayments.php';
            break;

        case 'getreturnedpayments':
            $controller = $basedir .'controllers/getreturnedpayments.php';
            break;

        case 'sendpayment':
            $controller = $basedir .'controllers/sendpayment.php';
            break;

        // Ruta no identificada
        default:
            die('sin ruta');
            break;
    }
}
