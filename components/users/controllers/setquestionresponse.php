<?php
/* components/users/controllers/setquestionresponse.php
 *
 *
 * Llamada asíncrona
 */
defined('_EXE') or die('Acceso restringido');

// Validar el token
require ROOTDIR.'/models/tokenator.php';
checkFormToken($_POST['token']);

$id = (integer)$_SESSION['user_id'];

$question = (string)$_POST['question'];

$response = (string)$_POST['response'];

include ROOTDIR.'/components/security/models/authentication.php';

echo setQuestionResponse($id, $question, $response);
