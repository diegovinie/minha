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

    case 'sim':
        include COMDIR .'sim/router.php';
        break;

    // Contenido dinámico
    case 'get':
        include 'controllers/rendertwig.php';
        break;

    case 'static':
        include ROOTDIR ."/components/{$route[2]}/static/{$route[3]}/{$route[4]}";
        break;

    case 'assets':
        include ROOTDIR ."/components/{$route[2]}/assets/{$route[3]}/{$route[4]}";
        break;


    // asinc Vistas estáticas /views/{tipo}
    case 'views':
        ob_start();
        include ROOTDIR .'/' .$route[1] .'/' .$route[2] .'/' .$route[3];
        $view = ob_get_clean();
        echo $view;
        exit;
        break;

    case 'prueba':
        $controller = ROOTDIR.'/tests/p.php';
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

        case 'recibos':
            include COMDIR. 'invoices/router.php';
            break;


        // Área de administradores
        case 'admin':
            // Si el tipo de sesión no es administrador termina
            if($_SESSION['role'] == 2) die('No tiene autorización.');
            switch ($route[2]) {
                case 'pagos':
                    include COMDIR .'payments/router.php';
                    break;

                case 'finanzas':
                    include COMDIR .'finances/router.php';
                    break;

                case 'recibos':
                    include COMDIR .'invoices/router.php';
                    break;

                case 'usuarios':
                    include COMDIR .'users/router.php';
                    break;

                // Componente Payments
                case 'gastos':
                    include COMDIR .'bills/router.php';
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
