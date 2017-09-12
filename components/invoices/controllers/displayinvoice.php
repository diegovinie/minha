<?php

include_once $basedir.'models/datainvoice.php';

//$number = 201709;
$aptid = (int)$_SESSION['apt_id'];

$number = (int)$_POST['number'];

echo createInvoice($aptid, $number);
