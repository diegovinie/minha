<?php
/* components/main/controllers/main.php
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
    "main"     => "/components/main/js/main.js",
    "forms"     => "/js/forms.js",
    "functions" => "/js/functions.js"
);

$loader = new Twig_Loader_Filesystem(ROOTDIR.'/');
$twig = new Twig_Environment($loader);

echo $twig->render(
    'components/main/views/main.html.twig',
    array('a' => $href, 'js' => $js)
);
