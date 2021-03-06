<?php
// Controlador: js/balance.js
// Modelo: core/async_balance.php

require '../datos.php';
session_start();
require ROOTDIR.'header.php';
require ROOTDIR.'menu.php';

 ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Balance</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Disponibilidad</h3>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Saldo Corriente:</th>
                                <td id="corriente" data-type='monto' data-value=10></td>
                            </tr>
                            <tr>
                                <th>Total Fondos:</th>
                                <td id="total_fondos" data-type='monto'></td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <th id="disponibilidad" data-type='monto'></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel panel-default" id="aptos">
                <div class="panel-heading">
                    <h3 class="panel-title">Balance por apartamento</h3>
                </div>
                <div class="panel-body" id="balance_apartamentos">
                    <!-- async data -->
                </div> <!--/panel-body-->
            </div> <!--/panel-->
        </div> <!-- /col-lg-6-->
        <div class="col-lg-8">
            <div class="panel panel-default" style="margin-bottom:80px;">
                <div class="panel-heading">
                    <h3 class="panel-title">Cuentas</h3>
                </div>
                <div class="panel-body" id="cuentas">
                    <!-- async data -->
                </div>
                <div class="panel-footer col-lg-12" style="text-align:right;">
                    <button type="button" name="agregar_proveedor" class="btn btn-primary" disabled>Nueva Cuenta</button>
                </div>
            </div>
            <div class="panel panel-default" style="margin-bottom:80px;">
                <div class="panel-heading">
                    <h3 class="panel-title">Fondos Especiales</h3>
                </div>
                <div class="panel-body" id="fondos">
                    <!-- async data -->
                </div>
                <div class="panel-footer col-lg-12" style="text-align:right;">
                    <button type="button" name="agregar_proveedor" class="btn btn-primary" disabled>Nuevo Fondo</button>
                </div>
            </div>
            <div class="panel panel-default" style="margin-bottom:80px;">
                <div class="panel-heading">
                    <h3 class="panel-title">Movimientos</h3>
                </div>
                <div class="panel-body" id="movimientos">
                    <!-- async data -->
                </div>
                <div class="panel-footer col-lg-12" style="text-align:right;">
                    <button type="button" name="agregar_proveedor" class="btn btn-primary" disabled>Nuevo Movimiento</button>
                </div>
            </div>
        </div>
    </div> <!-- /row-->
</div> <!--/page-wrapper-->
<script src="<?php echo PROJECT_HOST;?>js/balance.js" charset="utf-8"></script>
<?php
require ROOTDIR.'footer.php';
 ?>
