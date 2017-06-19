<?php
//Imagen con campos relativos
//Construye tabla dinámica a partir de datos json
session_start();
require '../datos.php';
require ROOTDIR.'server.php';
connect();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Minha Administradora</title>
        <link href="../css/style.css" type="text/css" media="all" rel="stylesheet" />


    </head>
    <body>
    <script language="Javascript">
    	function imprSelec(nombre) {
    	  var ficha = document.getElementById(nombre);
    	  var ventimp = window.open(' ', 'popimpr');
    	  ventimp.document.write( ficha.innerHTML );
    	  ventimp.document.close();
    	  ventimp.print( );
    	  ventimp.close();
    	}
	</script>
<?php
$session_user = $_SESSION['user'];
extract($_POST);
//Comprueba que fue enviado el formulario
if(isset($button)){
   //Solicita los datos del usuario
   $q1 = "SELECT udata_name, udata_surname, udata_ci, udata_number_fk, bui_apt FROM users, userdata, buildings WHERE user_user = '$session_user' AND udata_user_fk = user_id AND bui_id = udata_number_fk";
   $r1 = q_exec($q1);
   //Solicita índice, mes y año
   $q2 = "SELECT * FROM lapses WHERE lap_id = '$lapse'";
   $r2 = q_exec($q2);
   //Convierte las consultas en arrays
   $udata = query_to_array($r1);
   $lapdata = query_to_array($r2);

   //Construye el encabezado (arrays de única fila)
   echo "<br>";
   ?>
   <div id="imprimir">
    <link rel="stylesheet" href="../css/invoice.css">
    <div class="datos">
        <img src="../static/recibo.png" alt="">
        <span id="numero">F0000101</span>
        <span id="edificio">AVELLANA MORADA</span>
        <span id="nombre"><?php echo $udata[0]['udata_name'].' '.$udata[0]['udata_surname']; ?></span>
        <span id="ci"><?php echo $udata[0]['udata_ci']; ?></span>
        <span id="apartamento"><?php echo $udata[0]['bui_apt'] ?></span>
        <span id="mes"><?php echo $lapdata[0]['lap_name'] ?></span>

        <?php

       //Abre el archivo json donde está guardada la información de los recibos
       $file = fopen(ROOTDIR.'files/fact-'.$lapdata[0]['lap_year'].'-'.$lapdata[0]['lap_month'].'.json', 'r');
       //Pasa el contenido del archivo a una variable. Única fila
       $b = fgets($file);
       $c = json_decode($b);
       //El fact***.json es un array[obj cabecera, obj contenido]
       //Selecciona los datos para el apartamento seleccionado
       /*arreglar!!!
       */
       $invoice = $c[1]->{'10F'};
       //Variables para totalizar
       $porcentaje = 0.0;
       $total = 0.0;
       //Suma todos los porcentajes y los muestra en formato español
       foreach ($invoice as $item => $v) {
           $porcentaje += $invoice->$item->{'porcentaje'};
       }
       $porcentaje = number_format($porcentaje, 2, ',','.');
       //Suma todos los totales y los muestra en formato español
       foreach ($invoice as $item => $v) {
           $total += $invoice->$item->{'total'};
       }
       $total = number_format($total, 2, ',','.');
       ?>
       <table id="tabla">
           <?php foreach ($invoice as $item => $value): ?>
               <tr>
                   <?php foreach ($invoice->$item as $k => $v): ?>
                       <td id="tot"><?php if(is_numeric($v)){
                           echo number_format($v, 2, ',', '.');
                       }else{
                           echo $v;
                       } ?></td>

                   <?php endforeach; ?>
               </tr>
           <?php endforeach; ?>

               <tr>
                   <td></td>
                   <td id="porc">Total Apto:</td>
                   <td id="tot">Total Gen:</td>
               </tr>
               <tr>
                   <td></td>
                   <td id="porc"> <?php echo $porcentaje; ?></td>
                   <td id="tot"> <?php echo $total; ?></td>
               </tr>
       </table>
       <span id="monto"><?php echo $porcentaje; ?></span>
   </div>
   </div>
   <?php
}
 ?>
 <div class="button_box" align="center" style="position:fixed;top=0px;">
     <button type="submit" id='submit' name="print" class="button_hot principal" onclick="imprSelec('imprimir');" >Imprimir</button>
     <button type="submit" id='submit' name="save" class="button_hot principal" >Guardar</button>
     <button type="button" name="button" class="button_hot secundary" onclick="history.go(-1)">Regresar</button>
 </div>
    </body>
</html>
