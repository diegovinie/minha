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
    "functions" => "/js/functions.js",
    "moment"    => "/vendor/js/moment.min.js",
    "dpicker"   => "/vendor/js/dpicker.all.min.js"
);

$loader = new Twig_Loader_Filesystem(ROOTDIR.'/');
$twig = new Twig_Environment($loader);

echo $twig->render(
    'components/payments/views/manage.html.twig',
    array('a' => $href, 'js' => $js, 'menu' => $_menu)
);
