<?php

include_once $basedir.'models/datainvoice.php';
include_once $basedir.'models/invoicepdf.php';

//$number = 201709;
$aptid = (int)$_SESSION['apt_id'];

$number = (int)$_POST['number'];


$header = getInvoiceHeader($aptid, $number);
$content = getAptContentInvoice($aptid, $number);
$footer = getAptFootInvoice($aptid, $number);
//var_dump($header); die;

ob_start();
$inv = new InvoicePdf();

$inv->AddPage('P', [210/2, 220]);
//$inv->addBanner();
$inv->addHeader($header);
$inv->addContent($content);
$inv->addFooter($footer);
$inv->Output();

$pdfclean = ob_get_clean();
$pdf64 =  base64_encode($pdfclean);

echo $pdf64;
