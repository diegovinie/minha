<?php
/* components/users/router.php
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
if($route[1] == 'usuarios'){
    switch ($route[2]) {
        // Página de inicio
        case 'perfil':
            $controller = $basedir .'controllers/profile.php';
            break;

        case 'getquestion':
            $controller = $basedir .'controllers/getquestion.php';
            break;

        case 'setquestionresponse':
            $controller = $basedir .'controllers/setquestionresponse.php';
            break;

        case 'getpassworddialog':
            $controller = $basedir .'controllers/getpassworddialog.php';
            break;

        case 'setpassword':
            $controller = $basedir .'controllers/setpassword.php';
            break;

        case 'updatepersonal':
            $controller = $basedir .'controllers/updatepersonal.php';
            break;

        case 'updatenotes':
            $controller = $basedir .'controllers/updatenotes.php';
            break;
        // Abrir la ventana de agregar un pago
        /*case 'add':
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

        case 'edit':
            $controller = $basedir .'controllers/editpayment.php';
            break;*/

        // Ruta no identificada
        default:
            die('sin ruta');
            break;
    }
}

if($route[1] == 'admin' && $route[2] == 'usuarios'){

    // Identificador del 3er parámetro en /{primero}/{segundo}/{tercer}
    $route[3] = isset($route[3])? $route[3] : '';

    switch ($route[3]) {
        case '':
            $controller = $basedir .'controllers/manage.php';
            break;
        case 'getusers':
            $controller = $basedir .'controllers/getusers.php';
            break;
        case 'getpendingusers':
            $controller = $basedir .'controllers/getpendingusers.php';
            break;
        case 'aceptar':
            $controller = $basedir .'controllers/activeuser.php';
            break;
        case 'eliminar':
            $controller = $basedir .'controllers/deleteuser.php';
            break;

        case 'notas':
            $controller = $basedir .'controllers/getnotes.php';
            break;


        default:
            die('sin ruta');
            break;
    }
}
