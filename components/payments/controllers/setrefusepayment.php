<?php
/* components/payments/controllers/setrefusepayment.php
 *
 */

defined('_EXE') or die('Acceso restringido');

$payid = (int)$_GET['id'];
$obs = null; //(string)$_GET['obs'];

include $basedir .'/models/managepayments.php';

echo setRefusePayment($payid, $obs);
