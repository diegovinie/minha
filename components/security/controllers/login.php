<?php
/* components/security/controllers/login.php
 *
 * Controlador
 * Genera la Vista
 */
defined('_EXE') or die('Acceso restringido');

if(isset($_SESSION)) session_destroy();

// Datos para el formulario
$form = array(
    "action"    => "/index.php/login/check",
    "method"    => "post"
);

// Datos para los botones
$href = array(
    "register"  => "/index.php/register",
    "recovery"  => "/index.php/recovery"
);

// javascript a incluir
$js = array(
    "login"     => "/components/security/js/login.js",
    "forms"     => "/js/forms.js",
    "functions" => "/js/functions.js"
);

$loader = new Twig_Loader_Filesystem(ROOTDIR.'/');
$twig = new Twig_Environment($loader);

echo $twig->render(
    'components/security/views/login.html.twig',
    array('form' => $form, 'a' => $href, 'js' => $js)
);
