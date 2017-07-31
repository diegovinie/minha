<?php
/* router.php
 *
 * Enrutador principal
 * Se llama desde el controlador frontal
 * Debe retornar un controlador o incluir un enrutador secundario
 */

defined('_EXE') or die('No hay acceso');

// Directorio de componentes
$comdir = ROOTDIR.'/'.COMDIR;

switch ($route[1]) {
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
        $controller = $comdir .'security/controllers/recovery.php';
        break;
    // No se encuentra ruta
    default:
        print_r($route);
        die('sin ruta');
        break;
}

return $controller;
