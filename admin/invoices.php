<?php
// Controlador: js/invoices.js
// Modelo: core/async_invoices.php

require '../datos.php';
session_start();
require ROOTDIR.'header.php';
require ROOTDIR.'menu.php';
include ROOTDIR.'server.php';
connect();
$q = "SELECT lap_id, lap_name FROM lapses ORDER BY lap_id DESC";
$r = q_exec($q);
$lapses = query_to_assoc($r);

$dir = ROOTDIR.'files';
$gestor_dir = opendir($dir);
while(false !== ($nombre_fichero = readdir($gestor_dir))){
    if($nombre_fichero != '.' && $nombre_fichero != '..'){
        $a = substr($nombre_fichero, 0, strrpos($nombre_fichero, "."));
        $b = substr($a, 4, strlen($a));
        $month = substr($b, -2, strlen($b));
        $year = substr($b, 0, 4);
        $ficheros[$month.'/'.$year] = $b;
    }
}
 ?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h2 class="page-header">Recibos</h2>
        </div>
    </div>
    <!--<div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Ver y Comparar Recibos</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <div class="col-md-6" style="margin-bottom:10px;">
                            <label for="">Elegir:</label>
                            <select class="form-control" name="">
                                <?php
                                foreach ($ficheros as $key => $value) {
                                    ?>
                                <option value="<?php echo $value; ?>"><?php echo $key; ?></option>
                                <?php
                                }
                                 ?>
                            </select>
                        </div>
                        <button type="button" name="button" class="btn btn-primary btn-block" >Mostrar</button>
                        <div class="" id="header">

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-6" style="margin-bottom:10px;">
                            <label for="">Elegir:</label>
                            <select class="form-control" name="">
                                <?php
                                foreach ($ficheros as $key => $value) {
                                    ?>
                                <option value="<?php echo $value; ?>"><?php echo $key; ?></option>
                                <?php
                                }
                                 ?>
                            </select>
                        </div>

                        <button type="button" name="button" class="btn btn-primary btn-block" onclick="displayInvoice(this)" >Mostrar</button>
                        <div class="" id="summary">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    <div class="row">
        <div class="col-md-12">
            <form class="" action="<?php echo PROJECT_HOST;?>admin/make_invoices.php" method="get">
                <input type="text" name="fun" value="generate" hidden>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>Generar Recibos</h3>
                    </div>
                    <div class="panel-body">
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Periodo:</h4>
                                    <select class="form-control" name="lapse">
                                        <?php
                                        foreach ($lapses as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value['lap_id']; ?>"><?php echo $value['lap_name']; ?></option>
                                            <?php
                                        }
                                          ?>
                                    </select>
                                </div>
                            </div>
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a href="#agregar_gastos" data-toggle="collapse" data-parent="#accordion">Agregar Gastos</a>
                                    </h4>
                                </div>
                                <div  class="panel-body panel-collapse collapse in" id="agregar_gastos">
                                    tabla de gastos
                                </div>
                            </div>
                            <!--async info -->
                        </div>
                        <div class="checkbox" style="padding-bottom:10px;">
                            <label>
                                <input type="checkbox" name="ready" id="ready" onclick="activateOnCheck(this, 'gen')" value="">Cambios Completos
                            </label>
                        </div>

                        <button type="submit" name="button" id="gen" class="btn btn-block btn-lg btn-success">Generar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo PROJECT_HOST;?>js/invoices.js" charset="utf-8"></script>
<?php
require ROOTDIR.'footer.php';
 ?>
