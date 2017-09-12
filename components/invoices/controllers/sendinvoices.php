<?php

$buiid = (int)$_SESSION['bui_id'];
$number = 201709;

include_once $basedir.'models/sendinvoices.php';

echo sendEmailsToHabitants($number, $buiid);
