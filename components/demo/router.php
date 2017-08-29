<?php
/* components/demo/router.php
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
if($route[1] == 'demo'){
    switch ($route[2]) {
        // Página de registro
        case '':
            $controller = $basedir
                .'controllers/register.php';
            break;

        // Crear entorno
        case 'crear':
            $controller = $basedir .'controllers/creategame.php';
            break;

        // Ruta no identificada
        default:
            die('sin ruta');
            break;
    }
}
