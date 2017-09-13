<?php

include_once $basedir.'models/userinvoices.php';

$edf = $_SESSION['edf'];

$batchs = getBatchList($edf);

$js = array(
    'display' => '/index.php/assets/invoices/js/displayinvoice.js'
);

$twig = new LoadTwigWithGlobals($_globals['view']);
$twig->addExtension(new Twig_Extension_StringLoader());

echo $twig->render(
    'components/invoices/views/invoices.html.twig',
    array(
        'batchs' => $batchs,
        'js'     => $js
    )
);
