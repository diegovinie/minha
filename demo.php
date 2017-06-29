<?php

//Se establecen los parámetros de sesión
session_start();
$_SESSION['user_id'] = 2;
$_SESSION['user'] = 'admin@caracol';
$_SESSION['status'] = 'active';
$_SESSION['name'] = 'Curioso';
$_SESSION['val'] = 'activo';
$_SESSION['number_id'] = 1;
$_SESSION['apt'] = 2;
$_SESSION['bui'] = 'A17';

//Se define que tipo de usuario es
switch ($_GET['arg']) {
    case 1:
        $_SESSION['type'] = 1;
        //echo "ir a administrador";
        header("Location: main.php");
        break;
    case 2:
        $_SESSION['type'] = 2;
        //echo "ir a usuario";
        header("Location: main.php");
        break;
    default:
        echo "ha ocurrido un error";
        break;
}
 ?>
