<?php
/* components/security/controllers/getquestion.php
 *
 * Atiende de petición asíncrona
 * Imprime un json directo del modelo
 */
defined('_EXE') or die('Acceso restringido');

$email = mysql_escape_string((string)$_GET['email']);

include $basedir.'models/authentication.php';
echo getQuestion($email);

exit;
