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
    "payments"  => "/index.php/assets/payments/js/payments.js",
    "functions" => "/js/functions.js",
    "forms"     => "/js/forms.js",
    "moment"    => "/vendor/moment/moment.min.js",
    "dpicker"   => "/vendor/dpicker/dpicker.all.min.js"
);


$twig = new LoadTwigWithGlobals($_globals['view']);

echo $twig->render(
    'components/payments/views/index.html.twig',
    array(
        'form' => $form,
        'a' => $href,
        'js' => $js,
    )
);
