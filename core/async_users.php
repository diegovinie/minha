<?php
// Controlador: js/add_user.js js/signup.js, js/display_users.js
// Vista: admin/add_user.php, signup.php, admin/display_users.php

session_start();
require_once '../datos.php';
require_once ROOTDIR.'/server.php';
require_once ROOTDIR.'/core/functions.php';
connect();

if(isset($_GET['edificio'])){
    extract($_SESSION);
    $q = "SELECT bui_name FROM buildings WHERE bui_id = $apt";
    $r = q_exec($q);
    echo uniqueQuery($r);
}

if(isset($_GET['fun'])){
    extract($_GET);
    $bui = $_SESSION['bui'];
    switch ($fun) {
        case 'usuarios_registrados':
            $q = "SELECT udata_name AS 'Nombre', udata_surname AS 'Apellido',
        	        udata_ci AS 'C.I.',  bui_apt AS 'Apartamento',
        			user_user AS 'Correo', CASE user_type
        				WHEN 1 THEN 'Administrador'
        				WHEN 2 THEN 'Usuario'
        				ELSE 'Indeterminado'
        			END AS 'Tipo de Usuario'
        	    FROM users, userdata, buildings WHERE udata_user_fk = user_id AND udata_number_fk = bui_id AND user_active = 1 AND bui_name = '$bui'";
            $arg = $fun;
            break;
        case 'usuarios_pendientes':
        $q = "SELECT udata_id AS 'id', udata_name AS 'Nombre',
                udata_surname AS 'Apellido',
                udata_ci AS 'C.I.',
                bui_apt AS 'Apartamento',
                user_user AS 'Correo'
            FROM users, userdata, buildings WHERE udata_user_fk = user_id AND udata_number_fk = bui_id AND user_active = 0 AND bui_name = '$bui'";
            $arg = $fun;
            break;

        default:
            echo "problema"; die;
            break;
    }
    if(isset($wrapper)){
        $wrapper($fun, $q, $arg);
    }else{
        $fun($q, $arg);
    }
}

if(!isset($_POST['fun']) && isset($_POST['name']) && isset($_POST['surname']) &&
    isset($_POST['email']) && isset($_POST['pwd']) &&
    $_SESSION['type'] == 1){
    extract($_POST);
    $session_user = $_SESSION['user'];
    $q = "SELECT user_id FROM users WHERE user_user = '$email'";
    $r = q_exec($q);
    if(mysql_num_rows($r) == 0){
        //Se agregan los datos de acceso ya activando al usuario
        $q1 = "INSERT INTO users VALUES (NULL, '$email', '$pwd', '', '', $type, 1, '$session_user', NULL)";
        $r1 = q_log_exec($session_user, $q1);
        //Se seleccionan las claves foráneas para el usuario
        $q2 = "SELECT bui_id, user_id FROM users, buildings WHERE user_user = '$email' AND bui_apt = '$apt'";
        $r2 = q_exec($q2);
        foreach (mysql_fetch_array($r2) as $key => $value) {
            $fk[$key] = $value;
        }
        $q3 = "INSERT INTO userdata VALUES (NULL, '$name', '$surname', '$ci', NULL, $cond, 'M', $fk[0], $fk[1])";
        $r3 = q_exec($q3);
        echo '{"status": true, "msg": "Usuario agregado con éxito"}';
    }else{
        echo '{"status": false, "msg": "Error al guardar datos"}';
    }
}

if(isset($_POST['fun'])){
    extract($_POST);
    switch ($fun) {
        case 'signup':
            //Verificar si el usuario existe
            $q = "SELECT user_id FROM users WHERE user_user = '$email'";
            $r = q_exec($q);
            if(mysql_num_rows($r) == 0){
                //Registra en users usuario y clave como inactivo
                $pwd = md5($pwd);
                $q1 = "INSERT INTO users VALUES (NULL, '$email', '$pwd', '', '', 2, 0, 'register:$email', NULL)";
                $r1 = q_log_exec('register:$email', $q1);
                //Se obtienen los datos para las claves foráneas
                $q2 = "SELECT bui_id, user_id FROM users, buildings WHERE user_user = '$email' AND bui_name = '$edf' AND bui_apt = '$apt'";
                $r2 = q_exec($q2);
                foreach (mysql_fetch_array($r2) as $key => $value) {
                    $fk[$key] = $value;
                }
                //Se Insertan los datos del usuario
                $q3 = "INSERT INTO userdata VALUES (NULL, '$name', '$surname', NULL, NULL, '$cond', 'M', '$fk[0]', '$fk[1]')";
                $r3 = q_exec($q3);
                if($r3){
                    echo '{"status": true, "msg": "Registro Exitoso!"}';
                }else{
                    echo '{"status": false, "msg": "Error al guardar datos"}';
                }
            }else{
                echo '{"status": false, "msg": "Usuario ya existe"}';
            }
            break;

        default:
            # code...
            break;
    }
}

function usuarios_registrados($q, $id){
    $r = q_exec($q);
    table_open($id);
    table_head($r);
    table_tbody($r);
    table_close();
}

function usuarios_pendientes($q, $id){
    $r = q_exec($q);
    table_open($id);
    table_head($r);
    table_tbody($r);
    table_close();
}

 ?>
