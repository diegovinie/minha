<?php
/* components/users/controllers/manage.php
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
    "manage"  => "/components/users/js/manage.js",
    "functions" => "/js/functions.js",
);

$twig = new LoadTwigWithGlobals($_globals['view']);

echo $twig->render(
    'components/users/views/manage.html.twig',
    array('form' => $form,
    'a' => $href,
    'js' => $js,
    )
);
