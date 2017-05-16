<?php
//Formulario con verificación de campos JS
require '../datos.php';
session_start();
require ROOTDIR.'header.php';
require ROOTDIR.'menu.php';
?>
    <div class="" id='apart' hidden>
        <?php echo apartToString(); ?>
    </div>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-6">
                <h3>Añadir Usuario</h3>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Añadir Usuario
                    </div>
                    <div role="form" class="panel-body">
                        <form class="" action="add_user.php" method="post">
                            <div class="form-group">
                                <label for="">Nombre:</label>
                                <input class="form-control" type="text" name="name" value="nombre" onblur="capitalize(this)" required>
                            </div>
                            <div class="form-group">
                                <label for="">Apellido:</label>
                                <input class="form-control" type="text" name="surname" value="apellido" onblur="capitalize(this)" required>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="">Cédula de Identidad:</label>
                                        <input class="form-control" type="text" name="ci" value="v999999" onblur="capitalize(this)" required>
                                        <span class="help-block">Formato: V00000000</span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">Apartamento:</label>
                                        <input class="form-control" type="text" name="number" value="1A" onblur="check_number(this)" required>
                                    </div>
                                </div>



                            </div>

                            <div class="form-group">
                                <label for="">Correo-e:</label>
                                <input class="form-control" type="email" name="email" value="pun@correo" onblur="lowercase(this)" required>
                            </div>
                            <div class="form-group">
                                <label>Clave:</label>
                                <input class="form-control" type="password" name="pwd" id='pwd' value="1234" required>
                            </div>
                            <div class="form-group">
                                <label for="">Repita clave:</label>
                                <input class="form-control" type="password" name="rpwd" id='rpwd' value="1234" required onblur="val_pwd()">
                                <div class="warning" id="pwd_e" style="display:none">
                                las claves no coinciden
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tipo de usuario:</label>
                                <select class="form-control" name="type" required>
                                    <option selected>Seleccionar</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Usuario Registrado</option>
                                </select>
                            </div>
                            <div class="button_box" align="center">
                                <button type="submit" id='submit' name="button" class="btn btn-default" >Enviar</button>
                                <button type="button" name="button" class="btn btn-default" onclick="window.location.href='main.php'">Regresar</button>
                            </div>
                        </form>
                    </div>
                    <!-- /panel-body-->
                </div>
                <!-- /panel-->
            </div>
            <!-- /col-lg-6-->
            <div class="col-lg-3">

            </div>
        </div>
        <!-- /row-->
    </div>
    <!--/page-wrapper-->


<?php
extract($_POST);
$session_user = $_SESSION['user'];
//Se verifica que el formulario haya sido enviado
if( isset($name) &&      isset($surname) &&
    isset($ci) &&        isset($number) &&
    isset($email) &&     isset($pwd)    &&
    $_SESSION['type'] == 1){
    require ROOTDIR.'server.php';
    connect();
    //Se verifica que no exista ya el usuario
    $q = "SELECT user_id FROM users WHERE user_user = '$email'";
    $r = q_exec($q);
    if(mysql_num_rows($r) == 0){
        //Se agregan los datos de acceso ya activando al usuario
        $q1 = "INSERT INTO users VALUES (NULL, '$email', '$pwd', '$type', 1, '$session_user', NULL)";
        $r1 = q_log_exec($session_user, $q1);
        //Se seleccionan las claves foráneas para el usuario
        $q2 = "SELECT A17_id, user_id FROM users, A17 WHERE user_user = '$email' AND A17_number = '$number'";
        $r2 = q_exec($q2);
        foreach (mysql_fetch_array($r2) as $key => $value) {
            $fk[$key] = $value;
        }
        $q3 = "INSERT INTO userdata VALUES (NULL, '$name', '$surname', '$ci','$fk[0]', '$fk[1]')";
        $r3 = q_exec($q3);

        ?> <script type="text/javascript">
            alert('Usuario agregado con éxito');
        </script> <?php
    }else{
        ?><script type="text/javascript">
            alert('Usuario ya existe');
        </script> <?php
    }
}
require ROOTDIR.'footer.php';
 ?>
