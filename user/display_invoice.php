<?php
//Formulario con campos dinámicos
session_start();
require '../header.php';
require '../menu.php';
require '../server.php';

connect();
//Extrae los periodos de la base de datos
$qlapse = "SELECT lap_id, lap_name FROM lapses";
$rlapse = q_exec($qlapse);

 ?>
<h2>Mostrar Recibo</h2>
<form class="" action="invoice.php" method="post">
    <table>
         <tr>
             <td>Periodo: </td>
             <td><select class="" name="lapse" id='date'>
                 <?php
                 while($a = mysql_fetch_array($rlapse)){
                     ?>
                     <option value=<?php echo $a[0]; ?>><?php echo $a[1]; ?></option>
                     <?php
                 }
                  ?>
             </select></td>
         </tr>
    </table>
    <div class="button_box" align="center">
        <button type="submit" name="button" class="button_hot principal">Enviar</button>
        <button type="button" name="button" class="button_hot secundary" onclick="history.go(-1)">Regresar</button>
    </div>
</form>
<?php
require '../footer.php';
 ?>
