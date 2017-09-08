<?php
/* components/payments/controllers/getapprovedpayments.php
 *
 */

defined('_EXE') or die('Acceso restringido');

$buiid = (int)$_SESSION['bui_id'];

include $basedir .'/models/managepayments.php';

//echo getCurrentMonth($bui); die;
$res = json_decode(approvedPayments($buiid));

if($res->status != false){

    include ROOTDIR.'/controllers/tablebuilder.php';
    echo tableBuilder($res->table);

}else{
    echo $res->table;
}
