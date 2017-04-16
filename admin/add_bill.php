<?php
//Formulario con campos dinámicos
//Verificación de campos con JS

session_start();
require '../header.php';
require '../menu.php';
require '../server.php';
connect();
 ?>
<script src="/minha/js/forms.js" charset="utf-8"></script>
<script type="text/javascript">
    window.onload = function(){
        var date;
        date = document.getElementById('date');
        date.options[a.options.length - 1].setAttribute('selected', 'true');
    }
</script>

<?php
//Selecciona la lista de proveedores de la base de datos y la pega en el html
//como un json
$qprov = "SELECT up_id, up_alias, up_name, up_rif FROM usual_providers";
$rprov = q_exec($qprov);
$prov_ar = query_to_array($rprov);
$prov_json = json_encode($prov_ar) or die(json_last_error_msg());
echo "<div id='proveedor' hidden>$prov_json</div>\n";
//Repite la consulta de proveedores para tener los datos en memoria
$rprov = q_exec($qprov);

//Selecciona los meses para pegarlos en el html
$qlapse = "SELECT lap_id, lap_name FROM lapses";
$rlapse = q_exec($qlapse);

//Selecciona el tipo de soporte para pegarlo en el html
$qbkb = "SELECT bkb_id, bkb_name FROM backup_bills";
$rbkb = q_exec($qbkb);
 ?>
<h2 id="titulo" align="center">Añadir Gasto</h2>

<form class="" action="add_bill.php" method="post">
    <table align="center">
        <tr>
            <td>Fecha: </td>
            <td><input type="date" name="date" value=""></td>
        </tr>
        <tr>
            <td>Tipo de Gasto:</td>
            <td><select class="" name="type" onchange="fun1(this)">
                <option value="" default>Seleccione</option>
                <?php
                while($a = mysql_fetch_array($rprov)){
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
            <td><input type="text" name="name" id="name" value="" onblur="capitalize(this)"></td>
        </tr>
        <tr>
            <td>RIF:</td>
            <td><input type="text" name="rif" id="rif" value="" onblur="capitalize(this)"></td>
        </tr>
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
        <tr>
            <td>Monto: </td>
            <td><input type="text" name="amount" value="" id="amount" onchange="setIvaTotal()"></td>
        </tr>
        <tr>
                <td>IVA:<select class="" name="" id="alic" onchange="setIvaTotal()">
                <option value="0.12">12%</option>
                <option value="0.1">10%</option>
                <option value="0">Excento</option>
            </select></td>
            <td><input type="text" name="iva" value="" id="iva"></td>
        </tr>
        <tr>
            <td>Total: </td>
            <td><input type="text" name="total" value="" id="total" onchange="setIvaTotal()"></td>
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
            <td><textarea name="notes" rows="10" cols="20">
            </textarea></td>
        </tr>
    </table>
    <div class="button_box" align="center">
        <button type="submit" name="button" class="button_hot principal">Enviar</button>
        <button type="button" name="button" class="button_hot secundary" onclick="history.go(-1)">Regresar</button>
    </div>
</form>

 <?php
extract($_POST);
$session_user = $_SESSION['user'];
//Verifica si fue enviado el formulario
if(isset($date) &&
    isset($type) && isset($amount) &&
    $_SESSION['type'] == 1) {

    $amount = numToEng($amount);
    $iva = numToEng($iva);
    $total = numToEng($total);
    //Si no se pasan notas por el formulario se crea una variable vacía
    if(!isset($notes))
        $notes = '';
    $q = "INSERT INTO bills VALUES (NULL, '$date', '$name', '$rif', '$type', '$lapse', '$amount', '$iva', '$total', '$bk', '$notes', '$session_user', NULL)";
    $r = q_log_exec($session_user, $q);
    ?>
    <script type="text/javascript">
        alert('Registro almacenado con éxito');
    </script>
    <?php
}
require '../footer.php';
  ?>
