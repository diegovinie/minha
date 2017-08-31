<?php

include $basedir.'models/bills.php';

$desc   = $_POST['desc'];
$date   = $_POST['date'];
$buiid  = (int)$_POST['buiid'];
$habid  = (int)$_POST['habid'];
$provid = (int)$_POST['provid'];
$accid  = (int)$_POST['accid'];
$class  = $_POST['class'];
$method = $_POST['method'];
$log    = $_POST['log'];
$amount = (float)$_POST['amount'];
$iva    = (float)$_POST[''];
$total  = (float)$_POST[''];
$op     = $_POST[''];

$name = $_POST['name'];
$rif = $_POST['rif'];
