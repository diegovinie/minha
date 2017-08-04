<?php
/* components/payments/controllers/editpayment.php
 *
 *
 * Genera la vista
 */
defined('_EXE') or die('Acceso restringido');

$id = (int)$_GET['id'];

include $basedir .'models/payments.php';
echo editPayment($id);
