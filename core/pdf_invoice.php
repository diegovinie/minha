<?php
session_start();
require_once '../datos.php';
include_once 'pdf.php';
include_once '../server.php';
connect();
$bui = $_SESSION['bui'];

if(isset($_POST['lapse'])){
    $lapse = $_POST['lapse'];
}elseif(isset($_GET['lapse'])){
    $lapse = $_GET['lapse'];
}
$user = $_SESSION['user_id'];
$q = "SELECT udata_name, udata_surname, udata_ci, bui_apt FROM userdata INNER JOIN buildings ON udata_number_fk = bui_id WHERE udata_user_fk = '$user' ";

$r = q_exec($q);
$dat = query_to_assoc($r)[0];

$file = fopen(ROOTDIR."files/invoices/$bui/FAC-" .$lapse .'.json', 'r');

$a = fgets($file);
if (strlen($a) <= 1){
    $a = fgets($file);
}
$invoice = json_decode($a);
$apt = $dat['bui_apt'];
$bills = [];
foreach ($invoice->{'content'}->{"$apt"} as $key => $value) {
    foreach ($value as $key2 => $value2) {
        foreach ($value2 as $key3 => $value3) {
            $bills[$key][$key2][$key3] = $value3;
        }
    }
}

$data = [[1, 2, 3], [6,7,8],['FFWEFWFWF99W', 1234, 34567]];

$pdf = new PDF();

$pdf->grid = 5;


$pdf->AddPage('P', [210/2, 220]);
$pdf->format();
$e = $invoice->{'charges'}->{$dat['bui_apt']};

$pdf->encabezado($invoice->{'head'}->{'Gen Num'},
                $invoice->{'head'}->{'Periodo'},
                $invoice->{'head'}->{'fecha'},
                $invoice->{'head'}->{'Inmueble'},
                $invoice->{'charges'}->{$dat['bui_apt']},
                $dat);
$pdf->contenido($bills);
$pdf->foote($e);
$pdf ->Output();

 ?>
