<?php
/* components/payments/controllers/addpayment.php
 *
 *
 * Genera la vista
 */
defined('_EXE') or die('Acceso restringido');

include $basedir .'models/payments.php';
include ROOTDIR.'/models/tokenator.php';

$banks = json_decode(getBanks());

$edf = $_SESSION['edf'];
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

$twig = new LoadTwigWithGlobals($_globals['view']);

echo $twig->render(
    'components/payments/views/addpayment.html.twig',
    array(
        'form' => $form,
        'css'  => $css,
        'banks' => $banks,
        'edf' => $edf,
        'apt' => $apt,
        'title' => $title)
);
