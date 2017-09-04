<?php
/*
 *
 */

$atcid = (int)$_GET['id'];

include_once $basedir.'models/bills.php';

echo getProvidersList($atcid);
