<?php


include_once ROOTDIR.'/models/locale.php';
include_once ROOTDIR.'/models/validations.php';

$desc   = $_POST['desc'];
$date   = validateNotNull(validateDate($_POST['date']));
$buiid = (int)$_SESSION['bui_id'];
$habid = (int)$_SESSION['hab_id'];
$provid = (int)$_POST['prov'];
$accid  = (int)$_POST['acc'];
$class  = (string)$_POST['class'];
$log    = (string)$_POST['log'];
$amount = numToEng($_POST['amount']);
$iva    = numToEng($_POST['iva']);
$total  = numToEng($_POST['total']);
$op     = (int)$_POST['op'];

$name = validateNotNull($_POST['name']);
$rif = $_POST['rif'];

include_once $basedir.'models/bills.php';

if(!$provid){
    $provid = addProvider($name, $rif);
}

echo addbill($desc, $date, $buiid, $habid, $provid, $accid,
        $class, $log, $amount, $iva, $total, $op);
