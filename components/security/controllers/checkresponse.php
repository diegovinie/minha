<?php
/* components/security/controllers/checkresponse.php
 *
 * Atiende de petición asíncrona
 * Imprime un json directo del modelo
 */
defined('_EXE') or die('Acceso restringido');

$question = mysql_escape_string((string)$_POST['question']);
$response = mysql_escape_string((string)$_POST['response']);
$email = mysql_escape_string((string)$_POST['email']);

include $basedir.'models/authentication.php';
echo checkResponse($question, $response, $email);

exit;
