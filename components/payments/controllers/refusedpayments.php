<?php
/* components/payments/controllers/refusedpayments.php
 *
 */

defined('_EXE') or die('Acceso restringido');

$bui = (string)$_SESSION['bui'];

include $basedir .'/models/managepayments.php';

//echo getCurrentMonth($bui); die;
$res = json_decode(refusedPayments($bui));

if($res->table != false){

    include ROOTDIR.'/controllers/tablebuilder.php';
    echo tableBuilder($res->table);

}else{
    echo false;
}
