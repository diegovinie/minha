<?php
// Controlador: js/bills.js
// Modelo: async_bills.php

require '../datos.php';
session_start();
require ROOTDIR.'header.php';
require ROOTDIR.'menu.php';
 ?>


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
                    <button type="button" name="agregar_proveedor" class="btn btn-primary" onclick="window.location.href = 'add_bill.php';">Agregar Gasto</button>
					<button type="button" name="pdf_agregar_proveedor" class="btn btn-info" data-type="pdf" onclick="window.open('../core/async_bills.php?fun=genpdf&arg=gastos')" >Imprimir</button>
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
                    <button type="button" name="agregar_proveedor" class="btn btn-primary" disabled>Agregar Proveedor</button>
					<button type="button" name="pdf_agregar_proveedor" class="btn btn-info" data-type="pdf" onclick="window.open('../core/async_bills.php?fun=genpdf&arg=proveedores')" >Imprimir</button>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="<?php echo PROJECT_HOST;?>js/bills.js" charset="utf-8"></script>
 <?php
require ROOTDIR.'footer.php';
  ?>
