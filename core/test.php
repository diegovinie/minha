<?php
require '../datos.php';

$a = fopen(ROOTDIR.'files/fact-4-2017.json', 'r');
echo gettype($a);
echo "<br>";

/*
while(!feof($a)){
    echo fgets($a).'<br>';
}
*/
$b = fgets($a);
fclose($a);
$c = json_decode($b);
echo gettype($b);
echo "<br>";
echo gettype($c);
echo "<br>";
print_r($c[0]->{'fecha'});
print_r ($c[1]->{'10F'}->{'ELECTRICIDAD'}->{'porcentaje'});



 ?>
