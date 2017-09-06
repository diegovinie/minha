<?php
/* components/payments/controllers/sendpayment.php
 *
 * Proviene de petición asíncrona
 * Retorna json desde el modelo
 */

defined('_EXE') or die('Acceso restringido');

include ROOTDIR.'/models/locale.php';
include $basedir .'models/payments.php';

$collection = array(
    'edf'       =>  $_SESSION['edf'],
    'user'      => $_SESSION['user'],
    'aptid'      => getApartmentId((string)$_POST['apt']),
    'habid'     => (int)$_SESSION['hab_id'],
    'amount'    => (float)numToEng($_POST['amount']),
    'date'      => $_POST['date'],
    'type'      => (int)$_POST['type'],
    'n_op'      => (string)$_POST['n_op'],
    'bankid'    => (int)$_POST['bank'],
    'obs'     => (string)$_POST['obs']
);


echo $res = sendPayment($collection);
