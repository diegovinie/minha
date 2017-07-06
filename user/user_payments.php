<?php
// Modelo: core/async_user_payments.php
// Controlador: js/user_payments.js

session_start();
require '../datos.php';
require ROOTDIR.'header.php';
require ROOTDIR.'menu.php';
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
                    <button type="button" name="nuevo_pago" class="btn btn-primary btn-lg" style="float: right;" onclick="newPayment()">Registrar Nuevo Pago</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Pagos En Revisión</h4>
                </div>
                <div class="panel-body" id="pagos_en_revision">
                    <!-- async data -->
                </div>
                <div class="panel-footer">

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Pagos Devueltos</h4>
                </div>
                <div class="panel-body" id="devueltos">
                    <!-- async data -->
                </div>
                <div class="panel-footer">

                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/user_payments.js?<?php echo TOKEN; ?>" charset="utf-8"></script>

<?php
require '../footer.php';
if(isset($time_ini)) rec_exec_time($time_ini, __FILE__, __LINE__);
 ?>
