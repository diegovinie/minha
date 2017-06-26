<?php
// Controlador: js/display_users.js
// Modelo: core/async_users.php

require '../datos.php';
//Tabla dinámica
session_start();
require ROOTDIR.'header.php';
require ROOTDIR.'menu.php';
?>

<div id="page-wrapper">
	<div class="row">
        <div class="col-md-12">
            <h2 class="page-header">Usuarios</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default"  style="margin-bottom:80px;">
                <div class="panel-heading">
                    <h3 class="panel-title">Usuarios Registrados</h3>
                </div>
                <div class="panel-body" id="usuarios_registrados">
                    <!-- async data -->
                </div>
                <div class="panel-footer col-md-12" style="text-align:right;">
                    <button type="button" name="add_usuarios_registrados" class="btn btn-primary" onclick="window.location.href = 'add_user.php';">Agregar Usuarios</button>
					<button type="button" name="pdf_usuarios_registrados" class="btn btn-info" data-type="pdf" onclick="window.open('../core/async_users.php?fun=genpdf&arg=usuarios_registrados')" >Imprimir</button>
                </div>

            </div>
            <div class="col-md-12">

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" style="margin-bottom:80px;">
                <div class="panel-heading">
                    <h3 class="panel-title">Usuarios Pendiendes</h3>
                </div>
                <div class="panel-body" id="usuarios_pendientes">
                    <!-- async data -->
                </div>
				<div class="panel-footer button_box" align="center">
					<button type="submit" name="submits" class="btn btn-primary">Aplicar</button>
					<button type="reset" class="btn btn-default" onclick="resetAlerts(this)">Deshacer</button>
					<button type="button" name="pdf_usuarios_pendientes" class="btn btn-info" data-type="pdf" onclick="window.open('../core/async_users.php?fun=genpdf&arg=usuarios_pendientes');" >Imprimir</button>
				</div>
            </div>
        </div>
	</div>
</div>
<script src="<?php echo PROJECT_HOST; ?>js/display_users.js" charset="utf-8"></script>
<?php
require ROOTDIR.'footer.php';
 ?>
