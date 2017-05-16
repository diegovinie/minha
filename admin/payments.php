<?php
session_start();
require '../datos.php';
require ROOTDIR.'header.php';
require ROOTDIR.'menu.php';
require ROOTDIR.'server.php';
connect();
 ?>
<script src="<?php echo PROJECT_HOST;?>js/payments.js" charset="utf-8"></script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Pagos y Recibos</h1>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Mes Actual
                </div>
                <div class="panel-body" id="mes_actual">
                    <!-- async data -->
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Mes Anterior
                </div>
                <div class="panel-body" id="mes_anterior">
                    <!-- async data -->
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Últimos 3 Meses
                </div>
                <div class="panel-body" id="ultimos_tres">
                    <!-- async data -->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Pagos Pendientes por Revisión
                </div>
                <form class="" action="<?php echo PROJECT_HOST;?>core/async_payments.php" method="post">
                    <div class="panel-body" id="pagos_pendientes">
                        <!-- async data -->
                    </div>
                    <div class="panel-footer button_box" align="center">
                        <button type="submit" name="submits" class="btn btn-primary">Aplicar</button>
                        <button type="reset" class="btn btn-default" onclick="resetAlerts(this)">Deshacer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Pagos Rechazados
                </div>
                <div class="panel-body" id="pagos_rechazados">
                    <!-- async data -->
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Pagos Aprobados
                </div>
                <div class="panel-body" id="pagos_aprobados">
                    <!-- async data -->
                </div>
            </div>

        </div>
    </div>
</div>

<?php
require ROOTDIR.'footer.php';
 ?>
