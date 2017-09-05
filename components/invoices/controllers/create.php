<?php
/* components/invoices/controllers/create.php
 *
 * Procesa los datos
 * Genera la vista
 */
defined('_EXE') or die('Acceso restringido');

include ROOTDIR.'/models/locale.php';
//include ROOTDIR.'/models/validations.php';

$userid = (int)$_SESSION['user_id'];
$bui = $_SESSION['edf'];
$lapse = (int)$_POST['lapse'];
$bills = array();
$funds = array();

foreach ($_POST as $key => $value) {
    if(preg_match("/^chk/", $key) && $value == 1){
        list($prep, $id) = split('_', $key);
        $bills[] = (int)$id;
    }

    if(preg_match("/^fundt/", $key)){
        list($prep, $id) = split('_', $key);
        $funds[$id]['type'] = (int)$value;
    }

    if(preg_match("/^fundv/", $key)){
        list($prep, $id) = split('_', $key);
        $funds[$id]['val'] = numToEng($value);
    }
}

if(!$userid || !$bui || !$lapse) die('Hubo un problema en la selección.');

include $basedir.'models/invoices.php';

$res = generateInvoicesBatch( $userid, $bui, $lapse, $bills, $funds);

extract(json_decode($res, true));

if(!$status){
    var_dump($msg); die;
}

$js = array(
    'preview'  => '/index.php/assets/invoices/js/preview.js',
    'functions' => '/js/functions.js',
    'forms'     => '/js/forms.js'
);

$twig = new LoadTwigWithGlobals($_globals['view']);

echo $twig->render(
    'components/invoices/views/preview.html.twig',
    array(
        'js'    => $js,
        'head' => $msg['head'],
        'summary' => $msg['summary'],
        'number' => $msg['head']['Gen Num'],
        'discard' => '/index.php/admin/recibos/descartar'
    )
);
