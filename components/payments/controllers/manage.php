<?php
/* components/payments/controllers/manage.php
 *
 *
 * Genera la vista
 */
defined('_EXE') or die('Acceso restringido');

// Datos para los botones
$href = array(
    "register"  => "/index.php/register",
    "recovery"  => "/index.php/recovery"
);

// javascript a incluir
$js = array(
    "manage"  => "/components/payments/js/managepayments.js",
    "functions" => "/js/functions.js"
);

$twig = new LoadTwigWithGlobals($_globals['view']);

echo $twig->render(
    'components/payments/views/manage.html.twig',
    array('a' => $href, 'js' => $js)
);
