<?php
/* components/security/controllers/setpwd.php
 *
 * Atiende de petición asíncrona
 * Imprime un json directo del modelo
 */
defined('_EXE') or die('Acceso restringido');

include $basedir.'models/authentication.php';

$email = mysql_escape_string((string)$_POST['email']);
$response = mysql_escape_string((string)$_POST['response']);
$pwd = (string)$_POST['pwd'];

echo setPassword($email, $response, $pwd);

exit;
