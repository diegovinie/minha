<?php
session_start();
require_once '../datos.php';
include_once 'pdf.php';
include_once ROOTDIR.'server.php';
include_once ROOTDIR.'core/functions.php';
connect();
$bui = $_SESSION['bui'];
$apt = $_SESSION['apt'];

if(isset($_POST['lapse'])){
    $lapse = $_POST['lapse'];
}elseif(isset($_GET['lapse'])){
    $lapse = $_GET['lapse'];
}
$user = $_SESSION['user_id'];
$q = "SELECT udata_name, udata_surname, udata_ci, bui_apt FROM userdata INNER JOIN buildings ON udata_number_fk = bui_id WHERE bui_apt = '$apt' AND udata_cond = 1";

$r = q_exec($q);
$dat = query_to_assoc($r)[0];
$dat['udata_name'] = nombreEinicial($dat['udata_name']);
$dat['udata_surname'] = nombreEinicial($dat['udata_surname']);
$dat['udata_ci'] = beautifyCI($dat['udata_ci']);

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

ob_start();
$pdf = new PDF();

//$pdf->grid = 5;


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
$pdfclean = ob_get_clean();
$pdf64 =  base64_encode($pdfclean);

if(isset($_GET['fun']) && $_GET['fun'] == 'sendmail'){
    $data = array(
        'to' => $_SESSION['user'],
        'att' => $pdfclean,
        'invoice' => $invoice->{'head'}->{'Gen Num'}
    );
    include ROOTDIR.'core/includes/mail_invoice.php';
    echo '{"status": true, "msg": "El recibo ha sido enviado a tu dirección de correo registrada"}';
}else{
    echo $pdf64;
}

 ?>
