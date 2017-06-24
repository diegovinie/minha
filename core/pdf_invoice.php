<?php
session_start();
require_once '../datos.php';
include_once 'pdf.php';
include_once '../server.php';
connect();
if(isset($_POST['lapse'])){
    $lapse = $_POST['lapse'];
}elseif(isset($_GET['lapse'])){
    $lapse = $_GET['lapse'];
}
$user = $_SESSION['user_id'];
$q = "SELECT udata_name, udata_surname, udata_ci, A17_number FROM userdata INNER JOIN A17 ON udata_number_fk = A17_id WHERE udata_user_fk = '$user' ";

$r = q_exec($q);
$dat = query_to_assoc($r)[0];

$file = fopen(ROOTDIR.'files/invoices/FAC-' .$lapse .'.json', 'r');

$a = fgets($file);
if (strlen($a) <= 1){
    $a = fgets($file);
}
$invoice = json_decode($a);

$bills = [];
foreach ($invoice->{'content'}->{'10F'} as $key => $value) {
    foreach ($value as $key2 => $value2) {
        foreach ($value2 as $key3 => $value3) {
            $bills[$key][$key2][$key3] = $value3;
        }
    }
}

$data = [[1, 2, 3], [6,7,8],['FFWEFWFWF99W', 1234, 34567]];

$pdf = new PDF();
//$pdf->grid = 5;
$pdf->AddPage('P', [210/2, 220]);
$e = $invoice->{'charges'}->{$dat['A17_number']};

$pdf->encabezado($invoice->{'head'}->{'Gen Num'},
                $invoice->{'head'}->{'Periodo'},
                $invoice->{'head'}->{'fecha'},
                $invoice->{'charges'}->{$dat['A17_number']},
                $dat);
$pdf->contenido($bills);
$pdf->foote($e);
$pdf ->Output();

 ?>
