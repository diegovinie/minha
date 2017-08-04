<?php
/* components/security/controllers/recovery.php
 *
 * Controlador
 * Genera vista recovery
 */
defined('_EXE') or die('Acceso restringido');

$href = array(
    'recovery'  => '/index.php/recovery',
    'login'     => '/index.php/login'
);

// javascript a incluir
$js = array(
    "recovery"     => $basedir."js/recovery.js",
    "forms"     => "/js/forms.js",
    "functions" => "/js/functions.js"
);

$loader = new Twig_Loader_Filesystem(ROOTDIR.'/');
$twig = new Twig_Environment($loader);

echo $twig->render(
    'components/security/views/recovery.html.twig',
    array('a' => $href, 'js' => $js)
);
