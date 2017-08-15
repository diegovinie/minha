<?php
/* components/users/controllers/getpassworddialog.php
 *
 *
 * Llamada asíncrona
 */
defined('_EXE') or die('Acceso restringido');

// Datos para el formulario
include ROOTDIR .'/models/tokenator.php';

$form = array(
    "action"    => "/index.php/usuarios/setpassword",
    "method"    => "post",
    "token"     => createFormToken()
);

$loader = new Twig_Loader_Filesystem(ROOTDIR.'/');

$twig = new Twig_Environment($loader);

echo $twig->render(
    'components/users/views/profile/passworddialog.html.twig',
    array(
    'question' => $question,
    'form'  => $form
    )
);
