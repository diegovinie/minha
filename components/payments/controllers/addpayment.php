<?php
/* components/payments/controllers/addpayment.php
 *
 *
 * Genera la vista
 */
defined('_EXE') or die('Acceso restringido');

include $basedir .'models/payments.php';
include ROOTDIR.'/components/security/controllers/tokenator.php';

$banks = json_decode(getBanks());

$bui = $_SESSION['bui'];

$apt = $_SESSION['apt'];

$title = 'Agregar Pago';

// Datos para el formulario
$form = array(
    "action"    => "/index.php/payments/sendpayment",
    "method"    => "post",
    "token"     => createFormToken()
);

$css = array(
    "dpicker"   => '/css/dpicker.css'
);

$loader = new Twig_Loader_Filesystem(ROOTDIR.'/');
$twig = new Twig_Environment($loader);

echo $twig->render(
    'components/payments/views/addpayment.html.twig',
    array(
        'form' => $form,
        'css'  => $css,
        'banks' => $banks,
        'bui' => $bui,
        'apt' => $apt,
        'title' => $title)
);
