<?php
/* components/security/controllers/register.php
 *
 * Controlador
 * Genera la Vista register
 */
defined('_EXE') or die('Acceso restringido');

$titulo = "Registro";

$href = array(
    "return"    => "/index.php/login"
);

include ROOTDIR.'/models/tokenator.php';
$form = array(
    "action" => '/index.php/register/create',
    "method" => 'post',
    "token"  => createFormToken()
);

// javascript a incluir
$js = array(
    "register"     => "/components/security/js/register.js",
    "forms"     => "/js/forms.js",
    "functions" => "/js/functions.js"
);

$loader = new Twig_Loader_Filesystem(ROOTDIR.'/');
$twig = new Twig_Environment($loader);

//echo $twig->render('Hello {{ name }}!', array('name' => 'Fabien'));
echo $twig->render(
    'components/security/views/register.html.twig',
    array(
        'titulo'    => $titulo,
        'form'      => $form,
        'a'         => $href,
        'js'        => $js
    )
);
