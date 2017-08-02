<?php
/* router.php
 *
 * Enrutador principal
 * Se llama desde el controlador frontal
 * Debe retornar un controlador o incluir un enrutador secundario
 */

defined('_EXE') or die('Acceso restringido');

// Directorio de componentes
$comdir = ROOTDIR.'/'.COMDIR;


switch ($route[1]) {

    // Rutas no protegidas

    case "login":
        // Enrutador secundario de componente
        include $comdir .'security/router.php';
        break;
    case 'register':
        // Enrutador secundario de componente
        include $comdir .'security/router.php';
        break;
    case 'recovery':
        // Controlador
        include $comdir .'security/router.php';
        break;

    case 'logout':
        include $comdir .'security/router.php';
        break;

    // asinc Vistas estandar /views/{tipo}
    case 'views':
        ob_start();
        include ROOTDIR .'/' .$route[1] .'/' .$route[2] .'/' .$route[3];
        $view = ob_get_clean();
        echo $view;
        exit;
        break;

    default:

    // Rutas protegidas
    require ROOTDIR.'/'.ACCESS_CONTROL;

    switch ($route[1]) {
        // Página principal
        case '':
            include ROOTDIR .'/components/main/controllers/main.php';
            break;
        //
        case 'main':
            include $comdir.'main/router.php';
            break;

        // No se encuentra ruta
        default:
            print_r($route);
            die('sin ruta');
            break;
        break;
    }
}

return (isset($controller)? $controller : false);
