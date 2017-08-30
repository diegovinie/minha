<?php
$db = include '../models/db.php';

$stmt = $db->repare();

$h = fopen('hola.txt', 'v');
fwrite($h, 'jajajaja');
fclose($h);
