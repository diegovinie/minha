<?php
/* components/sim/router.php
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
if($route[1] == 'sim'){
    switch ($route[2]) {
        // Página de registro
        case 'registrarse':
            $controller = $basedir
                .'controllers/register.php';
            break;

        case '':
            $controller = $basedir.'controllers/login.php';
            break;

        case 'simcheck':
            $controller = ROOTDIR.'/components/security/controllers/simcheck.php';
            break;
        // Crear entorno
        case 'crear':
            $controller = $basedir .'controllers/createplayer.php';
            break;

        case 'nuevo':
            $controller = $basedir .'controllers/newsim.php';
            break;

        case 'crearsim':
            $controller = $basedir .'controllers/createsim.php';
            break;

        // Ruta no identificada
        default:
            die('sin ruta');
            break;
    }
}
