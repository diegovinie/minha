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
                         <input type="text" name="fun" value="signup" hidden>
                         <div class="form-group">
                             <label for="">Nombre:</label>
                             <input class="form-control" type="text" name="name" value="" placeholder="Nombre" required onblur="check_names(this);">
                             <div class="">

                             </div>

                         </div>
                         <div class="form-group">
                             <label for="">Apellido:</label>
                             <input class="form-control" type="text" name="surname" value="" placeholder="Apellido" required onblur="check_names(this);">
                             <div class="">

                             </div>
                         </div>
                         <div class="form-group">
                             <label for="">Correo Electrónico:</label>
                             <input class="form-control" type="email" name="email" value="" placeholder="correo@electron.ico" required onblur="check_user(this);">
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
                             <select class="form-control" name="cond">
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
                         <div class="form-group">
                             <input type="text" name="type" value="2" hidden>
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
        <script src="<?php echo PROJECT_HOST; ?>js/forms.js" charset="utf-8"></script>
        <script src="<?php echo PROJECT_HOST; ?>js/ajax.js" charset="utf-8"></script>
        <script src="<?php echo PROJECT_HOST.TEMPLATE;?>vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/signup.js" charset="utf-8"></script>
    </body>
</html>

 <?php
 extract($_POST);

 if( isset($name) &&      isset($surname) &&
     isset($ci) &&        isset($number) &&
     isset($email) &&     isset($pwd)){

     require 'server.php';
     connect();
     //Verificar si el usuario existe
     $q = "SELECT user_id FROM users WHERE user_user = '$email'";
     $r = q_exec($q);
     if(mysql_num_rows($r) == 0){
         //Registra en users usuario y clave como inactivo
         $q1 = "INSERT INTO users VALUES (NULL, '$email', '$pwd', 2, 0, 'register:$email', NULL)";
         $r1 = q_log_exec('register:$email', $q1);
         //Se obtienen los datos para las claves foráneas
         $q2 = "SELECT A17_id, user_id FROM users, A17 WHERE user_user = '$email' AND A17_number = '$number'";
         $r2 = q_exec($q2);
         foreach (mysql_fetch_array($r2) as $key => $value) {
             $fk[$key] = $value;
         }
         //Se Insertan los datos del usuario
         $q3 = "INSERT INTO userdata VALUES (NULL, '$name', '$surname', '$ci', NULL, 'M', '$fk[0]', '$fk[1]')";
         $r3 = q_exec($q3);

         ?> <script type="text/javascript">
             ventana('Registro Exitoso!', 'Gracias por registrarse, en breve será activado');
             setTimeout(function(){
                 window.location.href = 'login.php';
             }, 5000);

         </script> <?php
     }else{
         ?><script type="text/javascript">
             alert('Usuario ya existe');
         </script> <?php
     }

 }
// require 'footer.php';
  ?>
