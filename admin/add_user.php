<?php
// Formulario con verificación de campos JS
// Controlador: js/add_user.js
// Modelo: core/async_users.php

require '../datos.php';
session_start();
require ROOTDIR.'header.php';
require ROOTDIR.'menu.php';
?>
    <div class="" id='apart' hidden>

    </div>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h2 class="page-header">Agregar Usuarios</h2>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Añadir Usuario
                    </div>
                    <div role="form" class="panel-body">
                        <form class="" action="add_user.php" method="post">
                            <div class="form-group">
                                <label for="">Nombre:</label>
                                <input class="form-control" type="text" name="name" id="name" placeholder="Nombre"  onblur="check_names(this)" required>
                                <div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Apellido:</label>
                                <input class="form-control" type="text" name="surname" id="surname" onblur="check_names(this)" placeholder="Apellido" required>
                                <div class="">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="">Cédula de Identidad:</label>
                                        <input class="form-control" type="text" placeholder="V12345678" name="ci" id="ci" onblur="check_ci(this)">
                                        <div class="">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Apartamento:</label>
                                        <select class="form-control" name="apt" id="apt" required>

                                        </select>

                                        <!--<input class="form-control" type="text" name="number" value="" onblur="check_number(this)" required>-->
                                    </div>
                                </div>
                            </div>
                            <div class="form-inline">

                            </div>
                            <div class="form-group">
                                <label for="">Correo-e:</label>
                                <input class="form-control" type="email" id="email" name="email" placeholder="correo@electron.ico"  onblur="check_user(this, false)" required>
                                <div class="">

                                </div>
                                <span class="help-block">Este será el nombre de usuario</span>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="pwd">Clave:</label>
                                    <input class="form-control" placeholder="" type="text" name="pwd" id='pwd' value="<?php echo DEF_PWD; ?>" onblur="check_pwd(this)" readonly>
                                <span class="help-block">Esta será la clave por defecto</span>
                                </div>

                            </div>

                            <div class="form-group col-md-6">
                                <label>Tipo de usuario:</label>
                                <select class="form-control" name="type" id="type" required>
                                    <option selected>Seleccionar</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Usuario Registrado</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Condición:</label>
                                <select class="form-control" name="cond" id="cond" required>
                                    <option selected>Seleccionar</option>
                                    <option value="1">Titular</option>
                                    <option value="2">Familiar</option>
                                </select>
                            </div>
                            <div class="button_box" align="center">
                                <button type="submit" id='submit' name="button" class="btn btn-success" onclick="sendNewuser()" >Enviar</button>
                                <button type="button" name="button" class="btn btn-danger" onclick="window.location.href='display_users.php'">Regresar</button>
                            </div>
                        </form>
                    </div>
                    <!-- /panel-body-->
                </div>
                <!-- /panel-->
            </div>
            <!-- /col-md-6-->
            <div class="col-md-3">

            </div>
        </div>
        <!-- /row-->

    </div>
    <!--/page-wrapper-->
<script src="../js/add_user.js" charset="utf-8"></script>

<?php
require ROOTDIR.'footer.php';

 ?>
