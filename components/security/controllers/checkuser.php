<?php
/* components/security/controllers/checkuser.php
 *
 * Controlador secundario
 */
defined('_EXE') or die('Acceso restringido');

include ROOTDIR.'/components/security/models/authentication.php';

$user = mysql_escape_string((string)$_POST['user']);
$pwd = mysql_escape_string((string)$_POST['pwd']);
$rem = isset($_POST['remember']) ? 1 : 0;

echo $res_json = checkUser($user, $pwd, $rem);
die;
$res = json_decode($res_json);
