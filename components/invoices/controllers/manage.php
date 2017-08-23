<?php

include $basedir.'models/manage.php';

$bui = (string)$_SESSION['bui'];

// Los recibos para comparar
$invoices = json_decode(getInvoicesId($bui), true);

// selección de periodos
$lapses = json_decode(getLapses());

$tables['bills'] = json_decode(getBills($bui));

$funds = json_decode(getFunds($bui), true);
//print_r($funds); die;

// Creación del array $table_template
$loader = new Twig_Loader_Filesystem(ROOTDIR.'/');
$twig = new Twig_Environment($loader);

foreach ($tables as $key => $value) {
    $table_template[$key] = $twig->render(
        'views/tables/table2.html.twig',
        array(
            'table' => $value->table
        )
    );
}

include ROOTDIR.'/models/tokenator.php';

$form = array(
    'action' => '/index.php/admin/recibos/crear',
    'method' => 'post',
    'token'  => createFormToken()
);

// javascript a incluir
$js = array(
    "invoices"  => "/components/invoices/js/invoices.js",
    "functions" => "/js/functions.js"
);

$twig = new LoadTwigWithGlobals($_globals['view']);
$twig->addExtension(new Twig_Extension_StringLoader());

echo $twig->render(
    'components/invoices/views/manage.html.twig',
    array(
        'invoices' => $invoices['msg'],
        'lapses' => $lapses->msg,
        'bills' => $table_template['bills'],
        'funds' => $funds['msg'],
        'js'    => $js,
        'form'  => $form
    )
);
