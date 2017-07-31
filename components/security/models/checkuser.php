<?php
/* components/security/models/checkuser.php
 *
 * Modelo de verificación de credenciales de usuario
 * Retorna un json (status, msg, [otros])
 */

$db = include ROOTDIR.'/models/db.php';

function checkUser($user, $pwd, $remember){
    global $db;
    if($pwd != DEF_PWD) $pwd = md5($pwd);
    $stmt = $db->query(
        "SELECT user_id, user_user, user_pwd, user_type, user_active, udata_name, udata_surname, udata_number_fk, bui_name, bui_apt
        FROM users, userdata, buildings
        WHERE user_user = '$user' AND
            user_pwd = '$pwd' AND
            udata_user_fk = user_id AND
            udata_number_fk = bui_id"
    );
    // Si es igual a 1 puede entrar
    if($stmt->rowCount() != 1){
        return '{"status": false, "msg": "Clave inválida"}';
    }else{
        $values = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si es igual a "0" no está activado
        if($values['user_active'] == 0){
            return '{"status": false, "msg": "Aún no está activo. Contacte al administrador '.$adminemail .'"}';
        }else{
            //Se establecen los parámetros de sesión
            session_start();
            $_SESSION['user_id'] = $values['user_id'];
            $_SESSION['user'] = $user;
            $_SESSION['status'] = 'active';
            $_SESSION['name'] = $values['udata_name'];
            $_SESSION['surname'] = $values['udata_surname'];
            $_SESSION['val'] = $values['user_active'];
            $_SESSION['number_id'] = $values['udata_number_fk'];
            $_SESSION['apt'] = $values['bui_apt'];
            $_SESSION['bui'] = $values['bui_name'];

            //Se define que tipo de usuario es
            switch ($values['user_type']) {
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

            // Se Fija la cookie
            if($remember === 1){
                $token = md5(time().rand(0,100));
                $info = json_encode($_SESSION);
                $qc = "INSERT INTO cookies VALUES(null, 'remember', '$token', '$info', null)";
                try{
                    $db->exec($qc);
                    setcookie('remember', $token, time()+60*60*24, '/');
                    $cookie = $token;
                    echo 'bien';
                }catch(PDOStatement $err){
                    echo 'problemas al guardar cookie: ';
                    echo $err;
                    $cookie = false;
                }
            }else{
                $cookie = false;
            }

            return '{
                "status": true,
                "msg": "Sesión iniciada",
                "session": true
            }';
        }
    }
}
