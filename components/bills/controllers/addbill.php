<?php


include_once ROOTDIR.'/models/locale.php';
include_once ROOTDIR.'/models/validations.php';

$desc   = $_POST['desc'];
$date   = validateNotNull(validateDate($_POST['date']));
$buiid = (int)$_SESSION['bui_id'];
$habid = (int)$_SESSION['hab_id'];
$provid = (int)$_POST['prov'];
$accid  = (int)$_POST['acc'];
$actid  = (int)$_POST['act'];
$typeid  = (int)$_POST['type'];
$log    = (string)$_POST['log'];
$amount = numToEng($_POST['amount']);
$iva    = numToEng($_POST['iva']);
$total  = numToEng($_POST['total']);
$op     = (int)$_POST['op'];

$name = validateNotNull($_POST['name']);
$rif = $_POST['rif'];

include_once $basedir.'models/bills.php';

if(!$provid){
    $provid = addProviderSkill($name, $rif, $actid);
}

echo addbill($desc, $date, $buiid, $habid, $provid, $accid,
        $actid, $log, $amount, $iva, $total, $op);
