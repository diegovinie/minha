<?php
/* components/invoices/controllers/savebatch.php
 *
 *
 * Respuesta asíncronica
 */
defined('_EXE') or die('Acceso restringido');

$buiid = (int)$_SESSION['bui_id'];
$number = 201709;

include_once $basedir.'models/sendinvoices.php';

echo sendEmailsToHabitants($number, $buiid);
