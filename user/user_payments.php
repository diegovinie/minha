<?php
session_start();
require '../datos.php';
require ROOTDIR.'header.php';
require ROOTDIR.'menu.php';
require ROOTDIR.'server.php';

connect();


 ?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Pagos</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Historial de Pagos</h4>
                </div>
                <div class="panel-body" id="pagos">
                    <!-- async data -->
                </div>
                <div class="panel-footer">

                </div>
                <div class="panel-footer col-lg-12" style="margin-bottom: 60px;">
                    <button type="button" name="agregar_proveedor" class="btn btn-primary btn-lg" style="float: right;">Registrar Nuevo Pago</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Últimos Recibos</h4>
                </div>
                <div class="panel-body" id="recibos">
                    <!-- async data -->
                </div>
                <div class="panel-footer">

                </div>
            </div>
        </div>
    </div>


</div>

<?php
require '../footer.php';
 ?>
