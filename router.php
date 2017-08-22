<?php
/* router.php
 *
 * Enrutador principal
 * Se llama desde el controlador frontal
 * Debe retornar un controlador o incluir un enrutador secundario
 */

defined('_EXE') or die('Acceso restringido');

// Directorio de componentes
$comdir = COMDIR;

//include ROOTDIR.'/tests/getsession.php';

switch ($route[1]) {

    // Rutas no protegidas

    case "login":
        // Enrutador secundario de componente
        include COMDIR .'security/router.php';
        break;
    case 'register':
        // Enrutador secundario de componente
        include COMDIR .'security/router.php';
        break;
    case 'recovery':
        // Controlador
        include COMDIR .'security/router.php';
        break;

    case 'logout':
        include COMDIR .'security/router.php';
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
            include COMDIR .'main/controllers/main.php';
            break;

        //
        case 'main':
            include COMDIR.'main/router.php';
            break;

        // Componente Payments
        case 'pagos':
            include COMDIR .'payments/router.php';
        break;

        // Área de administradores
        case 'admin':
            // Si el tipo de sesión no es administrador termina
            if($_SESSION['type'] !== 1) die('No tiene autorización.');
            switch ($route[2]) {
                case 'pagos':
                    include COMDIR .'payments/router.php';
                    break;

                case 'balance':
                    include COMDIR .'finances/router.php';
                    break;

                case 'usuarios':
                    include COMDIR .'users/router.php';
                    break;

                default:
                    print_r($route);
                    die('sin ruta');
                    break;

            }
            break;

        case 'balance':
            include COMDIR .'finances/router.php';
            break;

        case 'usuarios':
            include COMDIR .'users/router.php';
            break;

        // No se encuentra ruta
        default:
            print_r($route);
            die('sin ruta desde el principal');
            break;
        break;
    }
}

return (isset($controller)? $controller : false);
