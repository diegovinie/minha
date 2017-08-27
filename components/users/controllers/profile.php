<?php
/* components/users/controllers/profile.php
 *
 *
 * Genera la vista
 */
defined('_EXE') or die('Acceso restringido');

$id = (integer)$_SESSION['user_id'];
$buiid = (integer)$_SESSION['number_id'];
$edf = (string)$_SESSION['bui'];

include $basedir .'models/profile.php';

$res1 = json_decode(getFromBuildings($buiid));

if($res1->status == true){
    $bui = $res1->msg;
}
else{
    print_r($res1); die;
}

$res2 = json_decode(getFromUserdata($id));

if($res2->status == true){
    $udata = $res2->msg;
}
else{
    print_r($res2); die;
}

$res3 = json_decode(getFromUsers($id));

if($res3->status == true){
    $user = $res3->msg;
}
else{
    print_r($res3); die;
}

include ROOTDIR .'/models/tokenator.php';

// Datos para el formulario
$form = array(
    "action"    => "/index.php/usuarios/actualizarperfil",
    "method"    => "post",
    "token"     => createFormToken()
);

// javascript a incluir
$js = array(
    "payments"  => "/components/users/js/profile.js",
    "functions" => "/js/functions.js",
    "form"      => "/js/forms.js",
    "moment"    => "/vendor/moment/moment.min.js",
    "dpicker"   => "/vendor/dpicker/dpicker.all.min.js"
);

$css = array(
    'dpicker'   => '/css/dpicker.css'
);

// Formulario de notas particular para cada edificio
$extra = "components/users/views/profile/{$edf}.html.twig";

$twig = new LoadTwigWithGlobals($_globals['view']);

echo $twig->render(
    'components/users/views/profile.html.twig',
    array('form' => $form,
    'js' => $js,
    'css' => $css,
    'bui' => $bui,
    'udata' => $udata,
    'user' => $user,
    'extra' => $extra,
    )
);
