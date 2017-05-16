<?php
//Formulario con campos dinámicos
session_start();
require '../datos.php';
require ROOTDIR.'header.php';
require ROOTDIR.'menu.php';
require ROOTDIR.'server.php';

connect();
//Extrae los periodos de la base de datos
$qlapse = "SELECT lap_id, lap_name FROM lapses";
$rlapse = q_exec($qlapse);

 ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>Mostrar Recibo</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
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
        </div>
    </div>
</div>


<?php
require '../footer.php';
 ?>
