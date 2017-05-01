<?php
require '../datos.php';

echo ROOTDIR.'files/tmp/charges1000001.json';
$file = fopen(ROOTDIR.'files/tmp/charges1000001.json', 'r+');
gettype($file);
echo '1';
echo $f = fread($file, filesize($file));
echo '2';
print_r($f);
echo "3";
die;

 ?>
