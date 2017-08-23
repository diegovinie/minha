<?php

include ROOTDIR.'/models/locale.php';
//include ROOTDIR.'/models/validations.php';

$user = (string)$_SESSION['user_user'];
$bui = $_SESSION['bui'];
$lapse = (int)$_POST['lapse'];

foreach ($_POST as $key => $value) {
    if(preg_match("/^chk/", $key) && $value == 1){
        list($prep, $id) = split('_', $key);
        $bills[] = (int)$id;
    }

    if(preg_match("/^fundt/", $key)){
        list($prep, $id) = split('_', $key);
        $funds[$id]['type'] = (int)$value;
    }

    if(preg_match("/^fundv/", $key)){
        list($prep, $id) = split('_', $key);
        $funds[$id]['val'] = numToEng($value);
    }
}

include $basedir.'models/invoices.php';

//var_dump(json_decode(getBillsInfo($bills))) ;
//var_dump(json_decode(getLapseInfo($lapse)));
//var_dump(json_decode(setBillsQueue($bills)));
//var_dump(json_decode(getAssignedApts($bui)));
//var_dump(json_decode(getNumberApts($bui)));
var_dump(json_decode(getBalanceFromBuildings($bui)));
die;

var_dump($bills);

var_dump($funds); die;
