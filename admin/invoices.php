<?php
require '../header.php';

 ?>

 <h2>Recibos</h2>

 <h3>Recibos generados</h3>
 <select class="" name="">


 <?php
 $files = array_diff(scandir(ROOTDIR.'/files'), array('..', '.'));

 print_r($files);

 foreach ($files as $key => $value) {
     ?> <option value=""><?php echo $value ?></option> <?php
 }
  ?>
 </select>

<h3>Último Lote de Recibos Generado</h3>


<?php
require '../footer.php';
 ?>
