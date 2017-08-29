<?php
/* components/payments/controllers/sendpayment.php
 *
 * Proviene de petición asíncrona
 * Retorna json desde el modelo
 */

defined('_EXE') or die('Acceso restringido');

include ROOTDIR.'/models/locale.php';

$collection = array(
    'bui'       =>  $_SESSION['bui'],
    'user'      => $_SESSION['user'],
    'napt'      => (int)$_SESSION['number_id'],
    'user_id'   => (int)$_SESSION['user_id'],
    'amount'    => (float)numToEng($_POST['amount']),
    'date'      => $_POST['date'],
    'type'      => (int)$_POST['type'],
    'n_op'      => (string)$_POST['n_op'],
    'bank'      => (int)$_POST['bank'],
    'notes'     => (string)$_POST['notes']
);

include $basedir .'models/payments.php';
echo $res = sendPayment($collection);
