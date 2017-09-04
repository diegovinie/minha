<?php
/* components/bills/controllers/addbill.php
 *
 *
 * Genera la vista
 */

defined('_EXE') or die('Acceso restringido');
//include $basedir.'models/finances.php';

$buiid = (int)$_SESSION['bui_id'];

include ROOTDIR.'/models/tokenator.php';
include $basedir.'models/bills.php';

$res = json_decode(getActypesList(), true);
$actypes = $res['msg'];

$res2 = json_decode(getAccountsList($buiid), true);
$accounts = $res2['msg'];

$form = array(
    'action' => '/index.php/admin/gastos/agregar',
    'method' => 'POST',
    'token'  => createFormToken()
);

// javascript a incluir
$js = array(
    "functions" => "/js/functions.js",
    "addbill"   => "/index.php/static/bills/js/addbill.js",
    "forms"     => '/js/forms.js'
);

$twig = new LoadTwigWithGlobals($_globals['view']);
$twig->addExtension(new Twig_Extension_StringLoader());
$twig->getExtension('Twig_Extension_Core')
    ->setNumberFormat(2, ',', '.');

echo $twig->render(
    'components/bills/views/billdialog.html.twig',
    array(
        'form'    => $form,
        'js'       => $js,
        'accounts' => $accounts,
        'actypes'   => $actypes
        //'bills' => $table_template['bills'],
    )
);
