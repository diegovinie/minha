<?php
/* components/security/router.php
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
if($route[1] == 'login'){
    switch ($route[2]) {
        // Comprobar credenciales
        case 'check':
            $controller = $basedir .'controllers/checkuser.php';
            break;
        // Página de login
        case '':
            $controller = $basedir .'controllers/login.php';
            break;
        // Ruta no identificada
        default:
            die('sin ruta');
            break;
    }
}

// Enrutador de /register/{opcion}
if($route[1] == 'register'){
    switch ($route[2]) {
        // Cambio asinc de edificio
        case 'edificios':
            ob_start();
            include ROOTDIR.'/files/INDEX.json';
            $buildings = ob_get_clean();
            echo ($buildings);
            exit;
            break;
        // Cambio asinc de edificio
        case 'apartamentos':
            ob_start();
            include ROOTDIR.'/files/EDI-'.$route[3].'.json';
            $apts = ob_get_clean();
            echo $apts;
            exit;
            break;
        // Envío de formulario(post)
        case 'create':
            $controller = $basedir .'controllers/createuser.php';
            break;
        // asinc Vistas estandar /views/{tipo}
        case 'views':
            ob_start();
            include ROOTDIR .'/' .$route[2] .'/' .$route[3] .'/' .$route[4];
            $view = ob_get_clean();
            echo $view;
            exit;
        // Página de registro
        case '':
            $controller = $basedir .'controllers/register.php';
            break;
        // Ruta no identificada
        default:
            # code...
            print_r($route);
            die('sin ruta');
            break;
    }
}
