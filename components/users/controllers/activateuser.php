<?php
/* components/users/controllers/activateuser.php
 *
 *
 * Llamada asíncrona
 */
defined('_EXE') or die('Acceso restringido');

$id = (integer)$_POST['id'];

include $basedir .'models/users.php';

if($_SESSION['type'] == 1){
    echo setUserActive($id);
}
else{
    echo '{"status": false, "msg": "No tiene autorización para hacer esta acción."}';
}
