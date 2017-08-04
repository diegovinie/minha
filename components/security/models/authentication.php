<?php
/* components/security/models/authentication.php
 *
 * Modelo de verificación de credenciales de usuario
 * Retorna un json (status, msg, [otros])
 */
defined('_EXE') or die('Acceso restringido');

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
        $status = false;
        $msg = "Clave inválida";

    }else{
        $values = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si es igual a "0" no está activado
        if($values['user_active'] == 0){
            $status = false;
            $msg = "Aún no está activo. Contacte al administrador $adminemail";

        }else{
            $status = true;
            $msg = "Sesión iniciada";

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
                    echo "ha ocurrido un error al definir el tipo de sesión";
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
                }catch(PDOStatement $err){
                    echo 'problemas al guardar cookie: ';
                    echo $err;
                    $cookie = false;
                }
            }else{
                $cookie = false;
            }
        }
    }
    $response = array(
        'status'    => $status,
        'msg'       => $msg,
        'session'   => $cookie
    );
    return json_encode($response);
}

function getQuestion($email){
    global $db;
    $stmt = $db->query(
        "SELECT user_question FROM users
        WHERE user_user = '$email'"
    );
    $question = (string)$stmt->fetch(PDO::FETCH_NUM)[0];
    $status = $question? true : false;
    return json_encode(array(
        'status' => $status,
        'question' => $question)
    );
}

function checkResponse($question, $response, $email){
    global $db;
    $response = md5($response);
    $stmt = $db->query(
        "SELECT user_response FROM users
        WHERE user_user = '$email'"
    );

    $origin = $stmt->fetch(PDO::FETCH_NUM)[0];

    if($response == $origin){
        $status = true;
        $msg = "Correcto!";
    }else{
        $status = false;
        $msg = "Los datos no coinciden";
    }
    return json_encode(array(
        'status' => $status,
        'msg' => $msg
    ));
}

function setPassword($email, $response, $pwd){
    global $db;
    $pwd = md5($pwd);
    $response = md5($response);
    $stmt = $db->query(
        "UPDATE users SET user_pwd = '$pwd'
        WHERE user_user = '$email' AND user_response = '$response'"
    );
    $stmt2 = $db->query(
        "SELECT user_pwd FROM users
        WHERE user_user = '$email'"
    );
    $verif = $stmt2->fetch(PDO::FETCH_NUM)[0];

    if($pwd === $verif){
        $status = true;
        $msg = "Clave guardada con éxito";
    }else{
        $status = false;
        $msg = $stmt;
    }
    return json_encode(array(
        'status' => $status,
        'msg' => $msg
    ));

}

function checkEmail($email){
    global $db;
    $stmt = $db->query(
        "SELECT user_id FROM users WHERE user_user = '$email'"
    );

    $status = $stmt->rowCount() == 1? true : false;

    return json_encode(array('status' =>  $status, 'count' => $stmt->rowCount()));
}

function checkOldPassword($id){
    global $db;
    $stmt = $db->query(
        "SELECT user_pwd FROM users
        WHERE user_id = $id"
    );
    if($stmt){
        $pwd = $stmt->fetch(PDO::FETCH_NUM)[0];
        $status = $pwd == DEF_PWD? true : false;
    }
    return json_encode(['status' => $status, 'old' => $pwd]);
}

function updatePassword($id, $old, $new){
    global $db;

    $stmt = $db->query(
        "SELECT user_pwd FROM users
        WHERE user_id = $id"
    );

    if($stmt){
        if($old == $stmt->fetch(PDO::FETCH_NUM)[0]){

            $new = md5($new);
            $ex = $db->exec(
                "UPDATE users SET user_pwd = '$new'
                WHERE user_id = $id"
            );

            if($ex){
                $status = true;
                $msg = "Clave guardada con éxito.";
            }else{
                $status = false;
                $msg = "No se pudo guardar la clave";
            }
        }else{
            $status = false;
            $msg = "La antigua clave no coincide.";
        }
    }else{
        $status = false;
        $msg = "Error interno.";
    }

    return json_encode(array('status' => $status, 'msg' => $msg));
}
