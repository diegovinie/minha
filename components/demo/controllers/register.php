<?php
/* components/demo/controllers/register.php
 *
 * Controlador
 * Genera la Vista register
 */
defined('_EXE') or die('Acceso restringido');

$titulo = "Crear Simulador";

$href = array(
    "return"    => "/index.php/login"
);

include ROOTDIR.'/models/tokenator.php';
$form = array(
    "action" => '/index.php/demo/crear',
    "method" => 'post',
    "token"  => createFormToken()
);

// javascript a incluir
$js = array(
    "register"     => "/components/demo/js/register.js",
    "forms"     => "/js/forms.js",
    "functions" => "/js/functions.js"
);

$loader = new Twig_Loader_Filesystem(ROOTDIR.'/');
$twig = new Twig_Environment($loader);

echo $twig->render(
    'components/security/views/register.html.twig',
    array(
        'titulo'    => $titulo,
        'form'      => $form,
        'a'         => $href,
        'js'        => $js
    )
);
