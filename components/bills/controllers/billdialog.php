<?php
/* components/bills/controllers/addbill.php
 *
 *
 * Genera la vista
 */

defined('_EXE') or die('Acceso restringido');
//include $basedir.'models/finances.php';

include ROOTDIR.'/models/tokenator.php';
include $basedir.'models/bills.php';

$form = array(
    'action' => '/index.php/admin/gastos/agregar',
    'method' => 'POST',
    'token'  => createFormToken()
);

// javascript a incluir
$js = array(
    "functions" => "/js/functions.js"
);

$twig = new LoadTwigWithGlobals($_globals['view']);
$twig->addExtension(new Twig_Extension_StringLoader());
$twig->getExtension('Twig_Extension_Core')
    ->setNumberFormat(2, ',', '.');

echo $twig->render(
    'components/bills/views/billdialog.html.twig',
    array(
        //'bills' => $table_template['bills'],
    )
);
