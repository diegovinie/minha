<?php
require 'datos.php';
session_start();
session_unset();
session_destroy();
require 'header.php';
 ?>
 </header>

<main>
 <div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Ingresar</h3>
                </div>
                <div class="panel-body">
                    <form class="" role="form" action="login.php" method="post">
                        <fieldset>


                        <div class="form-group">
                            <input class=form-control placeholder="E-mail" type="text" name="user" value="">
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="clave" type="password" name="pwd" value="">

                        </div>
                        <div class="checkbox">
                            <label for="">
                                <input type="checkbox" name="remember" value="remember">Recordarme
                            </label>
                        </div>
                        <button type="submit" name="button" class="btn btn-lg btn-success btn-block">Enviar</button>
                        </fieldset>
<!--button_hot principal-->
                    </form>
                </div>
            </div>
            <div class="panel">
                <a href="signup.php">Registrarse</a>
                <a href="#">Recuperar Clave</a>
            </div>
        </div>
    </div>
 </div>

<?php
//require 'footer.php';
extract($_POST);

//Verifica si el formulario fue enviado
if(isset($user) && isset($pwd)){
    require 'server.php';
    connect();
    $q = "SELECT user_id, user_user, user_pwd, user_type, user_active, udata_name, udata_number_fk FROM users, userdata WHERE user_user = '$user' AND user_pwd = '$pwd' AND udata_user_fk = user_id";
    $r = q_exec($q);
    $user_val = [];
    //Verifica si el usuario existe en la base de datos
    if(mysql_num_rows($r) == 1){
        foreach (mysql_fetch_assoc($r) as $key => $value) {
            $user_val[$key] = $value;
        }
        //Verifica si el usuario está activado
        if($user_val['user_active'] == 0){
            ?>
                <script type="text/javascript">
                    alert("Aún no está activo. Contacte al administrador nombre@correo.org");
                    window.location = "login.php";
                </script>
            <?php die;
        }
        //Se establecen los parámetros de sesión
        session_start();
        $_SESSION['user_id'] = $user_val['user_id'];
        $_SESSION['user'] = $user;
        $_SESSION['status'] = 'active';
        $_SESSION['name'] = $user_val['udata_name'];
        $_SESSION['val'] = $user_val['user_active'];
        $_SESSION['number_id'] = $user_val['udata_number_fk'];

        //Se define que tipo de usuario es
        switch ($user_val['user_type']) {
            case 1:
                $_SESSION['type'] = 1;
                echo "ir a administrador";
                header("Location: main.php");
                break;
            case 2:
                $_SESSION['type'] = 2;
                echo "ir a usuario";
                header("Location: main.php");
                break;
            default:
                echo "ha ocurrido un error";
                break;
        }
    }else{ ?>
        <p align="center">Usuario o clave inválidos</p>
        <?php
    }

}

 ?>
