<?php
require_once '../datos.php';
$ePost = escape_array($_POST);

//Verifica si el formulario fue enviado
if(isset($ePost['user']) && isset($ePost['pwd'])){
    extract($ePost);
    require '../server.php';
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
                //echo "ir a administrador";
                header("Location: ../main.php");
                break;
            case 2:
                $_SESSION['type'] = 2;
                //echo "ir a usuario";
                header("Location: ../main.php");
                break;
            default:
                echo "ha ocurrido un error";
                break;
        }
    }else{ ?>
        <div class="" style="position:absolute;top:50%;right:50%;font-size:20px;color:red;">
            Clave inválida
        </div>
        <script type="text/javascript">
            setTimeout(function(){
                window.location.href = "<?php echo PROJECT_HOST; ?>login.php";
            }, 2000);
        </script>
        <?php
    }
}
?>
