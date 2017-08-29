<?php
/* components/users/controllers/getquestion.php
 *
 *
 * Llamada asíncrona
 */
defined('_EXE') or die('Acceso restringido');

$email = $_SESSION['user'];

include ROOTDIR.'/components/security/models/authentication.php';

$res = json_decode(getQuestion($email));


if($res->status == true){
    $question = $res->question;
}
else{
    print_r($res); die;
}

// Datos para el formulario
include ROOTDIR .'/models/tokenator.php';

$form = array(
    "action"    => "/index.php/usuarios/setquestionresponse",
    "method"    => "post",
    "token"     => createFormToken()
);

$loader = new Twig_Loader_Filesystem(ROOTDIR.'/');

$twig = new Twig_Environment($loader);

echo $twig->render(
    'components/users/views/profile/question.html.twig',
    array(
    'question' => $question,
    'form'    => $form
    )
);
