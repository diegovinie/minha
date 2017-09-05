<?php
/* components/payments/controllers/getlastmonth.php
 *
 */

defined('_EXE') or die('Acceso restringido');

$buiid = (int)$_SESSION['bui_id'];

include $basedir .'/models/managepayments.php';
//sleep(2);
//echo getCurrentMonth($bui); die;
$res = json_decode(getLastMonth($buiid));

if($res->table != false){

    include ROOTDIR.'/controllers/tablebuilder.php';
    echo tableBuilder($res->table);

}else{
    echo false;
}
