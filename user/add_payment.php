<?php
session_start();
require '../header.php';
require '../menu.php';
require '../server.php';
extract($_SESSION);
connect();
$q1 = "SELECT bank_id, bank_name FROM banks";
$r1 = q_exec($q1);
$q2 = "SELECT A17_number FROM A17 WHERE A17_id = '$number_id'";
$r2 = q_exec($q2);

//$r1_ar = query_to_array($r1);
//$r1_json = json_encode($r1_ar) or die(json_last_error_msg());

//echo "<div id='bancos' hidden>$r1_json</div>";

 ?>
<h2>Registro de Pagos</h2>
 <form class="" action="add_payment.php" method="post">
     <table>
         <tr>
             <td>Apartamento </td>
             <td><input type="text" name="number" value="<?php echo mysql_fetch_array($r2)[0]; ?>" readonly></td>
         </tr>
         <tr>
             <td>Fecha de la Operación</td>
             <td><input type="date" name="date" value=""></td>
         </tr>

         <tr>
             <td>Tipo de Operación</td>
             <td><select class="" name="type">
                 <option value="1">Depósito</option>
                 <option value="2" selected>Transferencia</option>

             </select></td>
         </tr>
         <tr>
             <td>Número</td>
             <td><input type="text" name="n_op" value=""></td>
         </tr>
         <tr>
             <td>Banco</td>
             <td><select class="" name="bank">
                 <?php
                 while($a = mysql_fetch_array($r1)){
                     ?>
                     <option value=<?php echo $a[0]; ?>><?php echo $a[1]; ?></option>
                     <?php
                 }
                  ?>
             </select></td>
         </tr>
         <tr>
             <td>Monto</td>
             <td><input type="text" name="amount" value=""></td>
         </tr>
         <tr>
             <td>Obsercaciones</td>
             <td><textarea name="notes" rows="4" cols="20"></textarea></td>
         </tr>
         <tr>
             <td>Cargar archivo</td>
             <td><input type="file" name="datafile" value=""></td>
         </tr>

     </table>
     <div class="button_box" align="center">
         <button type="submit" name="submit" class="button_hot principal">Enviar</button>
         <button type="button" name="back" class="button_hot secundary" onclick="history.go(-1)">Regresar</button>
     </div>
 </form>

<?php
require '../footer.php';
if(isset($_POST['submit'])){
    extract($_POST);
    $q3 = "INSERT INTO payments VALUES (NULL, '$date', '$number_id', '$type', '$n_op', '$bank', '$amount', 0, '$notes', NULL, '$user_id')";
    $r3 = q_log_exec($user, $q3);
    ?>
    <script type="text/javascript">
        alert('hecho');
    </script>
    <?php
}
?>
