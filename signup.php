<?php
// Controlador: js/signup.js
// Modelo: core/async_users.php

require 'datos.php';
require 'header.php';
 ?>
</header>
<main>
<script src="<?php echo PROJECT_HOST;?>js/modal.js" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
             <h2 class="page-header">Registrarse</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
             <div class="panel panel-default">
                 <div class="panel-heading">
                     <h3 class="panel-title">Ingrese sus datos</h3>
                 </div>
                 <div class="panel-body">
                     <form class="" role="form" action="signup.php" method="post">
                         <div class="form-group">
                             <input type="text" name="type" value="2" hidden>
                         </div>
                         <input type="text" name="fun" value="signup" hidden>
                         <div class="form-group">
                             <label for="">Nombre:</label>
                             <input class="form-control" type="text" name="name" id="name" placeholder="Nombre" required onblur="check_names(this);">
                             <div class="">

                             </div>

                         </div>
                         <div class="form-group">
                             <label for="">Apellido:</label>
                             <input class="form-control" type="text" name="surname" id="surname" placeholder="Apellido" required onblur="check_names(this);">
                             <div class="">

                             </div>
                         </div>
                         <div class="form-group">
                             <label for="">Correo Electrónico:</label>
                             <input class="form-control" type="email" name="email" id="email" placeholder="correo@electron.ico" required onblur="check_user(this);">
                             <div class="" id="error_email">

                             </div>
                            <span class="help-block">Este será el nombre de usuario</span>
                         </div>
                         <div class="form-group col-md-7">
                             <label for="">Edificio:</label>
                             <!--<input class="form-control" type="text" name="ci" value="" placeholder="V12345678" required onblur="check_ci(this);">-->
                             <select class="form-control" id="edf" name="edf">
                                 <option value="">Seleccione</option>

                             </select>
                             <div class="">

                             </div>
                         </div>
                         <div class="form-group col-md-5">
                             <label for="">Apartamento:</label>
                             <select class="form-control" name="apt" id="apt">

                             </select>
                             <!--<input class="form-control" type="text" name="apt" id="apt" value="" required onblur="check_number(this, false)">-->
                             <div class="">

                             </div>
                         </div>
                         <div class="form-group col-md-8 col-md-offset-2">
                             <label for="">Condición</label>
                             <select class="form-control" name="cond" id="cond">
                                 <option value="1">Titular</option>
                                 <option value="2">Familiar</option>
                             </select>
                         </div>
                         <div class="form-group">
                             <label for="">Elija una clave:</label>
                             <input class="form-control" type="password" name="pwd" id="pwd" value="" placeholder="Al menos 6 caracteres" onblur="check_pwd(this)" required>
                             <div class="">

                             </div>
                         </div>
                         <div class="form-group">
                             <label for="">Repita la clave:</label>
                             <input class="form-control" type="password" name="rpwd" id="rpwd" value="" placeholder="Al menos 6 caracteres" required onblur="check_pwdretry(this)">
                             <div>

                             </div>
                         </div>
                         <div class="" align="center">
                             <button type="submit" name="bsubmit" id="submit" class="btn btn-success">Enviar</button>
                             <button type="reset" name="breset" class="btn btn-info">Limpiar</button>
                             <button type="button" name="breturn" onclick="window.location.href='login.php'" class="btn btn-danger">Regresar</button>
                         </div>
                     </form>
                 </div>
             </div>
        </div>
    </div>
</div>

            </main>
        </div>
        <script src="<?php echo PROJECT_HOST; ?>js/functions.js" charset="utf-8"></script>
        <script src="<?php echo PROJECT_HOST; ?>js/forms.js" charset="utf-8"></script>
        <script src="<?php echo PROJECT_HOST; ?>js/ajax.js" charset="utf-8"></script>
        <script src="<?php echo PROJECT_HOST.TEMPLATE;?>vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/signup.js" charset="utf-8"></script>
    </body>
</html>
