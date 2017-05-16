<?php
require '../datos.php';
session_start();
require ROOTDIR.'header.php';
require ROOTDIR.'menu.php';

 ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Balance</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-default" id="aptos">
                <div class="panel-heading">
                    Balance por apartamento
                </div>
                <div class="panel-body" id="balance_apartamentos">
                    <!-- async data -->
                </div> <!--/panel-body-->
            </div> <!--/panel-->
        </div> <!-- /col-lg-6-->
        <div class="col-lg-8">
            <div class="panel panel-default" style="margin-bottom:80px;">
                <div class="panel-heading">
                    Cuentas
                </div>
                <div class="panel-body" id="cuentas">
                    <!-- async data -->
                </div>
                <div class="panel-footer col-lg-12" style="text-align:right;">
                    <button type="button" name="agregar_proveedor" class="btn btn-primary">Nueva Cuenta</button>
                </div>
            </div>
            <div class="panel panel-default" style="margin-bottom:80px;">
                <div class="panel-heading">
                    <h4>Movimientos</h4>
                </div>
                <div class="panel-body" id="movimientos">
                    <!-- async data -->
                </div>
                <div class="panel-footer col-lg-12" style="text-align:right;">
                    <button type="button" name="agregar_proveedor" class="btn btn-primary">Nuevo Movimiento</button>
                </div>
            </div>
        </div>
    </div> <!-- /row-->
</div> <!--/page-wrapper-->
<script src="<?php echo PROJECT_HOST;?>js/balance.js" charset="utf-8"></script>
<?php
require ROOTDIR.'footer.php';
 ?>
