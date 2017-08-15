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

include ROOTDIR.'/components/security/models/authentication.php';

echo setPasswordFromOld($id, $old, $new);
