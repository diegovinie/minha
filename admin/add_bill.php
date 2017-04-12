<?php
require '../header.php';
require '../menu.php';
require '../server.php';
connect();
 ?>
 <script type="text/javascript">
     function fun1(self){
         var a = self.value;
         var j = document.getElementById("proveedor").innerHTML;
         var k = JSON.parse(j);
         for(var i = 0; i < k.length; i++){
             if(k[i].up_id == a){
                 var ename = document.getElementById("name");
                 ename.value = k[i].up_name;
                 var erif = document.getElementById("rif");
                 erif.value = k[i].up_rif;
             }
         }
         if(a != 1){
             ename.setAttribute('disabled', 'true');
             erif.setAttribute('disabled', 'true');
         }else{
             ename.removeAttribute('disabled');
             erif.removeAttribute('disabled');
         }
     }

     window.onload = function(){
         var a = document.getElementById('date');
         a.options[a.options.length - 1].setAttribute('selected', 'true');
     }

     function totalizar(){
         amount = parseFloat(document.getElementById('amount').value);
         alic = parseFloat(document.getElementById('alic').value);
         document.getElementById('iva').value = amount * alic;
         document.getElementById('total').value = amount + (amount * alic);
     }
 </script>
<?php
$qtype = "SELECT up_id, up_alias, up_name, up_rif FROM usual_providers";
$rtype = q_exec($qtype);
$type_ar = ArrayToJson($rtype);
$type_json = json_encode($type_ar) or die(json_last_error_msg());
echo "<div id='proveedor' hidden>$type_json</div>";
$rtype2 = q_exec($qtype);
$qlapse = "SELECT lap_id, lap_name FROM lapses";
$rlapse = q_exec($qlapse);

$qbkb = "SELECT bkb_id, bkb_name FROM backup_bills";
$rbkb = q_exec($qbkb);
 ?>
<main>
<h2 id="titulo">Añadir Gasto</h2>

<form class="" action="index.html" method="post">
    <table>
        <tr>
            <td>Fecha: </td>
            <td><input type="date" name="date" value=""></td>
        </tr>
        <tr>
            <td>Tipo de Gasto:</td>
            <td><select class="" name="type" onchange="fun1(this)">
                <option value="" default>Seleccione</option>
                <?php
                while($a = mysql_fetch_array($rtype2)){
                    ?>
                    <option value=<?php echo $a[0]; ?>><?php echo $a[1]; ?></option>
                    <?php
                }
                 ?>
            </select></td>
            <td><?php

             ?></td>
        </tr>
        <tr>
            <td>Nombre o Razón Social:</td>
            <td><input type="text" name="name" id="name" value=""></td>
        </tr>
        <tr>
            <td>RIF:</td>
            <td><input type="text" name="rif" id="rif" value=""></td>
        </tr>
        <tr>
            <td>Periodo: </td>
            <td><select class="" name="" id='date'>
                <?php
                while($a = mysql_fetch_array($rlapse)){
                    ?>
                    <option value=<?php echo $a[0]; ?>><?php echo $a[1]; ?></option>
                    <?php
                }
                 ?>
            </select></td>
        </tr>
        <tr>
            <td>Monto: </td>
            <td><input type="text" name="amount" value="" id="amount" onchange="totalizar()"></td>
        </tr>
        <tr>
                <td>IVA:<select class="" name="" id="alic" onchange="totalizar()">
                <option value="0.12">12%</option>
                <option value="0.1">10%</option>
                <option value="0">Excento</option>
            </select></td>
            <td><input type="text" name="iva" value="" id="iva"></td>
        </tr>
        <tr>
            <td>Total: </td>
            <td><input type="text" name="total" value="" id="total" onchange="totalizar()"></td>
        </tr>
        <tr>
            <td>Tipo de Soporte: </td>
            <td><select class="" name="bk">
                <?php
                while($a = mysql_fetch_array($rbkb)){
                    ?>
                    <option value=<?php echo $a[0]; ?>><?php echo $a[1]; ?></option>
                    <?php
                }
                 ?>
            </select></td>
        </tr>
        <tr>
            <td>Observaciones:</td>
            <td><input type="text" name="notes" value=""></td>
        </tr>
    </table>
    <div class="">
        <button type="submit" name="button" >Enviar</button>
        <button type="button" name="button" onclick="history.go(-1)">Regresar</button>
    </div>
</form>

 <?php
require '../footer.php';
  ?>
