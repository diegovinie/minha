<?php
require '../datos.php';
session_start();
require ROOTDIR.'header.php';
require ROOTDIR.'menu.php';
 ?>
<script src="<?php echo PROJECT_HOST;?>js/invoices.js" charset="utf-8"></script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h2 class="page-header">Recibos</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Ver Recibos</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <div class="col-md-6" style="margin-bottom:10px;">
                            <label for="">Año:</label>
                            <select class="form-control" name="">
                                <option value="">Primera</option>
                                <option value="">Segunda</option>
                            </select>
                        </div>
                        <div class="col-md-6" style="margin-bottom:10px;">
                            <label for="">Mes:</label>
                            <select class="form-control" name="">
                                <option value="">Primera</option>
                                <option value="">Segunda</option>
                            </select>
                        </div>
                        <button type="button" name="button" class="btn btn-primary btn-block" >Mostrar</button>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-6" style="margin-bottom:10px;">
                            <label for="">Año:</label>
                            <select class="form-control" name="">
                                <option value="">Primera</option>
                                <option value="">Segunda</option>
                            </select>
                        </div>
                        <div class="col-md-6" style="margin-bottom:10px;">
                            <label for="">Mes:</label>
                            <select class="form-control" name="">
                                <option value="">Primera</option>
                                <option value="">Segunda</option>
                            </select>
                        </div>
                        <button type="button" name="button" class="btn btn-primary btn-block" >Mostrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                    <h4 class="panel-title">Periodo: <span><input type="text" name="lapse" value="3" hidden>Marzo</span></h4>
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

<?php
require ROOTDIR.'footer.php';
 ?>
