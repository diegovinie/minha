<?php
/*
 *
 */

$atyid = (int)$_GET['id'];

include_once $basedir.'models/bills.php';

echo getActivitiesList($atyid);
