<?php
/* components/invoices/controllers/savebatch.php
 *
 *
 * Respuesta asíncronica
 */
defined('_EXE') or die('Acceso restringido');

include $basedir.'models/saveinvoicesbatch.php';

$buiid = (int)$_SESSION['bui_id'];
$number = (int)$_GET['number'];

echo saveInvoicesBatch($buiid, $number);
