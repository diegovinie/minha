<?php
/* components/security/controllers/checkuser.php
 *
 * Controlador secundario
 */

include ROOTDIR.'/components/security/models/checkuser.php';

$user = mysql_escape_string((string)$_POST['user']);
$pwd = mysql_escape_string((string)$_POST['pwd']);
$rem = isset($_POST['remember']) ? 1 : 0;

$res = checkUser($user, $pwd, $rem);

print_r(json_decode($res));
