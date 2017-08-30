<?php
/* components/security/controllers/login.php
 *
 * Controlador
 * Genera la Vista
 */
defined('_EXE') or die('Acceso restringido');

if(isset($_SESSION)) session_destroy();

include ROOTDIR .'/models/tokenator.php';
$t = createFormToken();
// Datos para el formulario
$form = array(
    "action"    => "/index.php/login/check",
    "method"    => "post",
    "token"     => $t
);

// Datos para los botones
$href = array(
    "register"  => "/index.php/register",
    "recovery"  => "/index.php/recovery",
    "demo"      => "/index.php/demo"
);

// javascript a incluir
$js = array(
    "login"     => "/components/security/js/login.js",
    "forms"     => "/js/forms.js",
    "functions" => "/js/functions.js"
);

$twig = new LoadTwigWithGlobals($_globals['view']);

echo $twig->render(
    'components/security/views/login.html.twig',
    array(
        'form' => $form,
        'a' => $href,
        'js' => $js
    )
);
