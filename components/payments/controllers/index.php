<?php
/* components/payments/controllers/payments.php
 *
 *
 * Genera la vista
 */
defined('_EXE') or die('Acceso restringido');

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
    "payments"  => "/components/payments/js/payments.js",
    "functions" => "/js/functions.js",
    "moment"    => "/vendor/js/moment.min.js",
    "dpicker"   => "/vendor/js/dpicker.all.min.js"
);

$loader = new Twig_Loader_Filesystem(ROOTDIR.'/');
$twig = new Twig_Environment($loader);

echo $twig->render(
    'components/payments/views/index.html.twig',
    array('form' => $form, 'a' => $href, 'js' => $js, 'menu' => $_menu)
);
