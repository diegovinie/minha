<?php
//Formulario con campos dinámicos
//Verificación de campos con JS
require '../datos.php';
session_start();
require ROOTDIR.'header.php';
require ROOTDIR.'menu.php';
require ROOTDIR.'server.php';
connect();
$bui = $_SESSION['bui'];

//Selecciona la lista de proveedores de la base de datos y la pega en el html
//como un json
$qprov = "SELECT up_id, up_alias, up_name, up_rif, up_fk_type, up_desc, up_op FROM usual_providers WHERE up_bui = '$bui'";
$rprov = q_exec($qprov);
$prov_ar = query_to_assoc($rprov);
$prov_json = json_encode($prov_ar) or die(json_last_error_msg());
echo "<div id='proveedor' hidden>$prov_json</div>\n";
//Repite la consulta de proveedores para tener los datos en memoria
$rprov = q_exec($qprov);

//Selecciona los meses para pegarlos en el html
$qlapse = "SELECT lap_id, lap_name FROM lapses";
$rlapse = q_exec($qlapse);

 ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h2 id="titulo" class="page-header">Agregar Gasto</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-body">
                    <form class="" action="admin/add_bill.php" method="post">
                        <div class="form-group col-md-8">
                            <label for="">Proveedor:</label>
                            <select class="form-control" name="prov" id="prov" onchange="select_prov(this)">
                                <option value="0" default>Otro</option>
                                <?php
                                while($a = mysql_fetch_array($rprov)){
                                    ?>
                                    <option value=<?php echo $a[0]; ?>><?php echo $a[1]; ?></option>
                                    <?php
                                }
                                 ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Fecha:</label>
                            <input placeholder="aaaa-mm-dd" class="form-control" type="date" name="date" id="date" value="" onblur="">
                            <div class="">

                            </div>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="">Nombre o Razón Social:</label>
                            <input class="form-control" type="text" name="name" id="name" value="" onblur="capitalize(this)">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Forma de Pago:</label>
                            <select class="form-control" name="method" id="method">
                                <option value="CHEQUE">Cheque</option>
                                <option value="CAJA CHICA">Caja Chica</option>
                                <option value="TRANSFERENCIA">Transferencia</option>
                                <option value="PAGO ELECTRONICO">Pago Electrónico</option>
                                <option value="TDD" selected>Tarjeta de Débido</option>
                                <option value="TDC">Tarjeta de Crédito</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">Descipción:</label>
                            <input class="form-control" placeholder="40 caracteres máximo" maxlength="40" type="text" name="desc" id="desc" value="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">RIF:</label>
                            <input class="form-control" type="text" name="rif" id="rif" value="" onblur="capitalize(this)">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Tipo de Gasto:</label>
                            <!--<input class="form-control" type="text" name="class" id="spe_type" value="" onblur="check_type(this)">-->
                            <select class="form-control" name="" id="spe_type">
                                <option value="1" id="up_fk_type_1">PERSONAL</option>
                                <option value="2" id="up_fk_type_2">MATERIALES</option>
                                <option value="3" id="up_fk_type_3">SERVICIOS</option>
                                <option value="4" id="up_fk_type_4">BIENES</option>
                                <option value="5" id="up_fk_type_5">LEGAL</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Forma de Cargo:</label>
                            <select class="form-control" name="up_op" id="up_op">
                                <option value="">Seleccione:</option>
                                <option value="0" id="up_op_0">Equitativo</option>
                                <option value="1" id="up_op_1">Ponderado</option>
                            </select>
                        </div>
                        <div class="from-group col-md-5">
                            <label for="">Monto:</label>
                            <input class="form-control" type="text" name="amount" value="" id="amount" placeholder="use ',' para separar decimales" onchange="setIvaTotal()">
                        </div>
                        <div class="form-group col-md-7" style="text-align:center;">
                            <div class="col-md-12">
                                <label for="">IVA:</label>
                            </div>

                            <div class="col-md-4">
                                <select class="form-control" width="12px" name="" id="alic" onchange="setIvaTotal()">
                                    <option value="0.12">12%</option>
                                    <option value="0.1">10%</option>
                                    <option value="0">Excento</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <input class="form-control" width="12px" type="text" name="iva" value="" id="iva">
                            </div>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Total:</label>
                            <input class="form-control" type="text" name="total" value="" id="total" onchange="setIvaTotal()">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Tipo de Soporte:</label>
                            <select class="form-control" name="log" id="log">
                                <option value="COMPROBANTE">Comprobante</option>
                                <option value="FACTURA">Factura</option>
                                <option value="RECIBO">Recibo</option>
                                <option value="N/D" selected>Ninguno</option>
                            </select>
                        </div>
                        <div class="button_box" align="center">
                            <button type="submit" name="submit" class="btn btn-success">Enviar</button>
                             <button type="button" name="back" class="btn btn-warning" onclick="history.go(-1)">Regresar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
window.onload = function(){
    var list = ['prov','date', 'name', 'method', 'desc', 'rif', 'spe_type', 'up_op', 'amount', 'alic', 'log'];
    pressEnterNext(list);
}
</script>


 <?php
require ROOTDIR.'footer.php';
$session_user = $_SESSION['user'];
$bui = $_SESSION['bui'];
//Verifica si fue enviado el formulario
if(isset($_POST['date']) &&
    isset($_POST['submit']) && isset($_POST['amount']) &&
    $_SESSION['type'] == 1) {
    $ePost = escape_array($_POST);
    extract($ePost);
    $amount = numToEng($amount);
    $iva = numToEng($iva);
    $total = numToEng($total);
    if($method == 'CAJA CHICA'){
        $account = 2;
    }else{
        $account = 1;
    }

    $q = "INSERT INTO bills VALUES (NULL, '$date', '$bui', '$class', '$desc', '$name', '$rif', $account, '$method', '$log', 0, $amount, $iva, $total, '$session_user', NULL)";
    $r = q_log_exec($session_user, $q);

    $q2 = "UPDATE accounts SET acc_balance = acc_balance - $total WHERE acc_id = $account";
    $r2 = q_exec($q2);
    ?>
    <script type="text/javascript">
    ventana('Gasto almacenado', '');
    setTimeout(function(){
        window.location.href = 'main.php';
    }, 2000);
    </script>
    <?php
}

  ?>
