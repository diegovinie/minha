<?php
/* components/security/controllers/login.php
 *
 * Controlador
 * Genera la Vista
 */
defined('_EXE') or die('Acceso restringido');

if(isset($_SESSION)) session_destroy();

include ROOTDIR .'/models/tokenator.php';

// Datos para el formulario
$form = array(
    "action"    => "/index.php/sim/simcheck",
    "method"    => "post",
    "token"     => createFormToken()
);

// Datos para los botones

// javascript a incluir
$js = array(

    "forms"     => "/js/forms.js",
    "functions" => "/js/functions.js"
);

$twig = new LoadTwigWithGlobals($_globals['view']);

echo $twig->render(
    'components/sim/views/login.html.twig',
    array(
        'form' => $form,

    )
);
