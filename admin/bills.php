<?php
require '../datos.php';
session_start();
require ROOTDIR.'header.php';
require ROOTDIR.'menu.php';
 ?>
 <script src="<?php echo PROJECT_HOST;?>js/bills.js" charset="utf-8"></script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Gastos y Proveedores</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default"  style="margin-bottom:80px;">
                <div class="panel-heading">
                    <h3 class="panel-title">Gastos Realizados</h3>
                </div>
                <div class="panel-body" id="gastos">
                    <!-- async data -->
                </div>
                <div class="panel-footer col-lg-12" style="text-align:right;">
                    <button type="button" name="agregar_proveedor" class="btn btn-primary btn-lg" onclick="window.location.href = 'add_bill.php';">Agregar Gasto</button>
                </div>

            </div>
            <div class="col-lg-12">

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default" style="margin-bottom:80px;">
                <div class="panel-heading">
                    <h3 class="panel-title">Proveedores Registrados</h3>
                </div>
                <div class="panel-body" id="proveedores">
                    <!-- async data -->
                </div>
                <div class="panel-footer col-lg-12" style="text-align:right;">
                    <button type="button" name="agregar_proveedor" class="btn btn-primary btn-lg" disabled>Agregar Proveedor</button>
                </div>
            </div>
        </div>
    </div>
 <?php
require ROOTDIR.'footer.php';
  ?>
