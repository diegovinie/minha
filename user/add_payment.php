<?php
session_start();
require '../datos.php';
require ROOTDIR.'header.php';
require ROOTDIR.'menu.php';
require ROOTDIR.'server.php';
extract($_SESSION);
connect();
$q1 = "SELECT bank_id, bank_name FROM banks";
$r1 = q_exec($q1);
$q2 = "SELECT A17_number FROM A17 WHERE A17_id = '$number_id'";
$r2 = q_exec($q2);

 ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h2  class="page-header">Registro de Pagos</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Ingrese los datos de su operación
                </div>
                <div role="form" class="panel-body">
                    <form class="" action="add_payment.php" method="post">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="">Apartamento:</label><input  class="form-control" type="text" name="number" value="<?php echo mysql_fetch_array($r2)[0]; ?>" readonly>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="">Fecha de la Operación:</label>
                                <input class="form-control" placeholder="aaaa-mm-dd" type="date" name="date" value="" required>
                                <div class="">

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tipo de Operación:</label>
                            <select class="form-control" name="type">
                                <option value="1">Depósito</option>
                                <option value="2" selected>Transferencia</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">Número Operación:</label>
                                    <input class="form-control" type="text" name="n_op" value="" required>
                                </div>
                            </div>
                            <div class="col-md-4">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Banco:</label>
                            <select class="form-control" name="bank">
                                <?php
                                while($a = mysql_fetch_array($r1)){
                                    ?>
                                    <option value=<?php echo $a[0]; ?>><?php echo $a[1]; ?></option>
                                    <?php
                                }
                                 ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Monto:</label><input class="form-control" placeholder="use ',' para separar decimales" type="text" name="amount" value="" onblur="checkNumEsp(this)" required>
                            <div class="">

                            </div>
                        </div>
                        <div class="form-group">
                            <label>Obsercaciones:</label>
                            <textarea class="form-control" name="notes" rows="4" cols="20"></textarea>
                        </div>
                        <!--<div class="form-group">
                            <label for="">Cargar Imagen:</label>
                            <input class="form-control" type="file" name="datafile" value="">
                        </div>-->
                        <div class="button_box" align="center">
                            <button type="submit" id='submit' name="submit" class="btn btn-success btn-lg" >Enviar</button>
                            <button type="reset" name="button" class="btn btn-info btn-lg" onclick="window.location.href='main.php'">Limpiar</button>
                        </div>
                    </form>
                </div> <!-- /panel-body-->
            </div> <!-- /panel-->
        </div><!-- /col-md-6-->
        <div class="col-md-3">

        </div>
    </div>
</div>
<?php
require '../footer.php';
if(isset($_POST['submit'])){
    extract($_POST);
    $amount = numToEng($amount);
    $q3 = "INSERT INTO payments VALUES (NULL, '$date', '$number_id', '$type', '$n_op', '$bank', $amount, 0, '$notes', NULL, '$user_id')";
    $r3 = q_log_exec($user, $q3);
    ?>
    <script type="text/javascript">
        ventana('', 'hecho');
    </script>
    <?php
}
?>
