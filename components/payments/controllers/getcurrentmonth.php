<?php
/* components/payments/controllers/getcurrentmonth.php
 *
 */

defined('_EXE') or die('Acceso reintido');

$buiid = (int)$_SESSION['bui_id'];

include $basedir .'/models/managepayments.php';
//sleep(2);
//echo getCurrentMonth($bui); die;
$res = json_decode(getCurrentMonth($buiid));

if($res->table != false){

    include ROOTDIR.'/controllers/tablebuilder.php';
    echo tableBuilder($res->table);

}else{
    echo false;
}
