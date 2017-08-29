<?php
/* components/security/controllers/checkuser.php
 *
 * Controlador secundario
 */
defined('_EXE') or die('Acceso restringido');

include $basedir.'models/authentication.php';
include ROOTDIR.'/models/tokenator.php';
include ROOTDIR.'/models/validations.php';

//$user = (string)validateEmail($_POST['user']);
$user = (string)$_POST['user'];
$pwd = (string)$_POST['pwd'];
$rem = isset($_POST['remember']) ? 1 : 0;
sleep(1);
checkFormToken($_POST['token']);


echo $res_json = checkUser($user, $pwd, $rem);
