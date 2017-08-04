<?php
/* components/payments/controllers/removepayment.php
 *
 *
 * Genera la vista
 */
defined('_EXE') or die('Acceso restringido');

$id = (int)$_GET['id'];

include $basedir .'models/payments.php';
echo removePayment($id);
