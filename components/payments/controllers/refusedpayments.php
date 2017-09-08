<?php
/* components/payments/controllers/refusedpayments.php
 *
 */

defined('_EXE') or die('Acceso restringido');

$buiid = (int)$_SESSION['bui_id'];

include $basedir .'/models/managepayments.php';

//echo getCurrentMonth($bui); die;
$res = json_decode(refusedPayments($buiid));

if($res->status != false){

    include ROOTDIR.'/controllers/tablebuilder.php';
    echo tableBuilder($res->table);

}else{
    echo false;
}
