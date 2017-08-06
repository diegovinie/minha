<?php
/* components/security/controllers/checkuser.php
 *
 * Controlador secundario
 */
defined('_EXE') or die('Acceso restringido');

include $basedir.'models/authentication.php';
include $basedir.'controllers/tokenator.php';

$user = mysql_escape_string((string)$_POST['user']);
$pwd = mysql_escape_string((string)$_POST['pwd']);
$rem = isset($_POST['remember']) ? 1 : 0;

if(checkFormToken($_POST['token'])){

    echo $res_json = checkUser($user, $pwd, $rem);
}else{
    $res = '{"status": false, "msg": "El Formulario fue alterado."}';
    die($res);
}
