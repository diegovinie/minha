<?php
/* components/security/controllers/checkoldpassword.php
 *
 * Proviene de llamada asíncrona
 */
defined('_EXE') or die('Acceso restringido');

if(!isset($_SESSION)) session_start();

$id = $_SESSION['user_id'];

include $basedir .'models/authentication.php';
echo checkOldPassword($id);
