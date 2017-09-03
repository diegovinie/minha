<?php
/* components/sim/controllers/newsim.php
 *
 * Controlador
 * Genera la Vista register
 */
defined('_EXE') or die('Acceso restringido');

$titulo = "Crear Simulador";

include_once ROOTDIR.'/components/security/models/users.php';

$id = $_SESSION['id'];

$email = getEmail($id);

$href = array(
    "return"    => "/index.php/login"
);

include ROOTDIR.'/models/tokenator.php';
$form = array(
    "action" => '/index.php/sim/crearsim',
    "method" => 'post',
    "token"  => createFormToken()
);

// javascript a incluir
$js = array(
    "register"     => "/index.php/static/sim/js/newsim.js",
    "forms"     => "/js/forms.js",
    "functions" => "/js/functions.js"
);

$loader = new Twig_Loader_Filesystem(ROOTDIR.'/');
$twig = new Twig_Environment($loader);

echo $twig->render(
    'components/sim/views/newsim.html.twig',
    array(
        'titulo'    => $titulo,
        'form'      => $form,
        'a'         => $href,
        'js'        => $js,
        'email'     => $email
    )
);
