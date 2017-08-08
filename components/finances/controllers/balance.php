<?php
/* components/finances/controllers/balance.php
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
    "moment"    => "/vendor/moment/moment.min.js",
    "dpicker"   => "/vendor/dpicker/dpicker.all.min.js"
);


$twig = new LoadTwigWithGlobals($_globals['view']);

echo $twig->render(
    'components/finances/views/balance.html.twig',
    array('form' => $form,
    'a' => $href,
    'js' => $js,
    )
);
