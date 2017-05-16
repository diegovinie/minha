<?php
require '../datos.php';
//Graba contenidos temporales de lo que se va a grabar en charges
$file = fopen(ROOTDIR.'files/'.$_POST['name'].'.json', 'w');
fwrite($file, $_POST['data']);
fclose($file);
echo "Recibos ".$_POST['name']." generados con éxito";
 ?>
