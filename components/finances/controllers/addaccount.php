<?php
/* components/finances/controllers/addaccount.php
 *
 *
 * Genera la vista
 */
defined('_EXE') or die('Acceso restringido');

include $basedir .'models/finances.php';
include ROOTDIR.'/models/tokenator.php';


$title = 'Agregar Pago';

// Datos para el formulario
$form = array(
    "action"    => "/index.php/payments/sendpayment",
    "method"    => "post",
    "token"     => createFormToken()
);


$twig = new LoadTwigWithGlobals($_globals['view']);

echo $twig->render(
    'components/finances/views/addaccount.html.twig',
    array(
        'form' => $form,
        //'css'  => $css,
        //'banks' => $banks,
        //'edf' => $edf,
        //'apt' => $apt,
        //'title' => $title
    )
);
