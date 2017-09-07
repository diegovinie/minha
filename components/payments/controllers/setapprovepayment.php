<?php
/* components/payments/controllers/setapprovepayment.php
 *
 */

defined('_EXE') or die('Acceso restringido');

$payid = (int)$_GET['id'];

include $basedir .'/models/managepayments.php';

echo setApprovePayment($payid);
