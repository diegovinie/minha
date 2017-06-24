<?php
// Controlador: js/login.js
// Vista: login.php

require_once '../datos.php';
require '../server.php';
$con = connect();
$ePost = escape_array($_POST);

if(isset($_GET['fun'])){
    extract($_GET);
    switch ($fun) {
        case 'email':
            $q = "SELECT user_question FROM users WHERE user_user = '$user'";
            $r = q_exec($q);
            echo uniqueQuery($r);
            break;
        default:
            # code...
            break;
    }
}

if(isset($ePost['response']) && isset($ePost['email']) && isset($ePost['fun'])){
    if($ePost['fun'] == 'checkResponse'){
        extract($ePost);
        $response = md5($response);
        $q = "SELECT user_response FROM users WHERE user_user = '$email'";
        $r = q_exec($q);
        $origin = uniqueQuery($r);
        if($response == $origin){
            echo '{"status": true, "msg": "Correcto!"}';
        }else{
            echo '{"status": false, "msg": "Los datos no coinciden"}';
        }
    }
}

//Verifica si el formulario fue enviado
if(isset($ePost['user']) && isset($ePost['pwd'])){
    extract($ePost);
    if($pwd != DEF_PWD) $pwd = md5($pwd);
    $q = "SELECT user_id, user_user, user_pwd, user_type, user_active, udata_name, udata_number_fk, bui_name FROM users, userdata, buildings WHERE user_user = '$user' AND user_pwd = '$pwd' AND udata_user_fk = user_id AND udata_number_fk = bui_id";
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
        $_SESSION['apt'] = $user_val['udata_number_fk'];
        $_SESSION['bui'] = $user_val['bui_name'];

        //Se define que tipo de usuario es
        switch ($user_val['user_type']) {
            case 1:
                $_SESSION['type'] = 1;
                //echo "ir a administrador";
                break;
            case 2:
                $_SESSION['type'] = 2;
                //echo "ir a usuario";
                break;
            default:
                echo "ha ocurrido un error";
                die;
                break;
        }
        if(isset($remember)){
            $token = md5(time().rand(0,100));
            $info = json_encode($_SESSION);
            $qc = "INSERT INTO cookies VALUES(null, 'remember', '$token', '$info', null)";
            setcookie('remember', $token, time()+60*60*24, '/');
            $rc = q_exec($qc);
        }
        echo '{"status": true, "msg": "Positivo"}';
        //header("Location: ../main.php");
    }else{
        echo '{"status": false, "msg": "Clave inválida"}';
        die;
        ?>
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

if(isset($ePost['fun']) && isset($ePost['pwd']) && isset($ePost['response']) && isset($ePost['email'])){
    if($ePost['fun'] == 'savepassword'){
        extract($ePost);
        $pwd = md5($pwd);
        $response = md5($response);
        $q = "UPDATE users SET user_pwd = '$pwd' WHERE user_user = '$email' AND user_response = '$response'";
        $r = q_exec($q);
        // Verifica
        $q2 = "SELECT user_pwd FROM users WHERE user_user = '$email'";
        $r2 = q_exec($q2);
        $verif = uniqueQuery($r2);
        if($pwd == $verif){
            echo '{"status": true, "msg": "Clave guardada con éxito"}';
        }else{
            echo '{"status": false, "msg": "No se pudo completar la operación"}';
        }
    }
}
if(isset($time_ini)) rec_exec_time($time_ini, __FILE__, __LINE__);
