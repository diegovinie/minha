<?php
/* components/security/controllers/login.php
 *
 * Controlador
 * Genera la Vista
 */

include ROOTDIR .'/components/security/models/login.php';

// Se revisa si tiene sesión guardada en cookie
if(isset($_COOKIE['remember'])){
    $remember = $_COOKIE['remember'];
    $res = json_decode(checkRemember($remember));

    if($res->status == true){
        header('Location: /index.php/main');
        exit;
    }
}

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

$loader = new Twig_Loader_Filesystem(ROOTDIR.'/');
$twig = new Twig_Environment($loader);

echo $twig->render(
    'components/security/views/login.html.twig',
    array('form' => $form, 'a' => $href)
);
