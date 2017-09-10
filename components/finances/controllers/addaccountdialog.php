<?php
/* components/finances/controllers/addaccount.php
 *
 *
 * Genera la vista
 */
defined('_EXE') or die('Acceso restringido');

include $basedir .'models/createaccount.php';
include ROOTDIR.'/models/tokenator.php';

$buiid = (int)$_SESSION['bui_id'];

$res = json_decode(getHabitantsList($buiid), true);

$habs = $res['status'] == true? $habs = $res['msg'] : null;

$res2 = json_decode(getAcctypesList(), true);

$types = $res2['status'] == true? $res2['msg'] : null;

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
        'habs' => $habs,
        'types' => $types,
        //'css'  => $css,
        //'banks' => $banks,
        //'edf' => $edf,
        //'apt' => $apt,
        //'title' => $title
    )
);
