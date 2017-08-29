<?php
/* components/users/controllers/activateuser.php
 *
 *
 * Llamada asíncrona
 */
defined('_EXE') or die('Acceso restringido');

$habid = (integer)$_POST['hab_id'];

include $basedir .'models/users.php';

if($_SESSION['role'] == 1){
    echo acceptHabitant($habid);
}
else{
    echo '{"status": false, "msg": "No tiene autorización para hacer esta acción."}';
}
