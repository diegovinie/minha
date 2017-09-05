<?php
/* components/invoices/controllers/discardbatch.php
 *
 *
 * Respuesta asincrónica
 */
defined('_EXE') or die('Acceso restringido');

include $basedir.'models/invoices.php';

$bui = $_SESSION['edf'];
$number = (int)$_GET['number'];

echo discardInvoicesBatch($bui, $number);
