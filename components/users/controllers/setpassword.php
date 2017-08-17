<?php
/* components/users/controllers/setpassword.php
 *
 *
 * Llamada asíncrona
 */
defined('_EXE') or die('Acceso restringido');

// Validar el token
require ROOTDIR.'/models/tokenator.php';
checkFormToken($_POST['token']);

$id = (integer)$_SESSION['user_id'];

$old = (string)$_POST['pwd_old'];

$new = (string)$_POST['pwd_new'];

if($old == $new) die('{"status": false, "msg": "La clave nueva es igual a la actual"}');

include ROOTDIR.'/components/security/models/authentication.php';

echo setPasswordFromOld($id, $old, $new);
