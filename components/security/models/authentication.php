<?php
/* components/security/models/authentication.php
 *
 * Modelo de verificación de credenciales de usuario
 * Retorna un json (status, msg, [otros])
 */
defined('_EXE') or die('Acceso restringido');

include_once ROOTDIR.'/models/db.php';
include_once ROOTDIR.'/models/modelresponse.php';
include_once ROOTDIR.'/models/hashpassword.php';

function checkUser(/*string*/ $user, /*string*/ $pwd, /*int*/ $remember){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;
    $cookie = false;

    if($pwd != DEF_PWD) $pwd = hashPassword($pwd);
    $stmt = $db->prepare(
        "SELECT user_id, user_user, user_pwd,
        user_type, user_active, udata_name,
        udata_surname, udata_number_fk,
        bui_name, bui_apt
        FROM {$prx}users, {$prx}userdata, {$prx}buildings
        WHERE user_user = :user AND
            user_pwd = :pwd AND
            udata_user_fk = user_id AND
            udata_number_fk = bui_id"
    );

    $res = $stmt->execute(array(
        'user' => $user,
        'pwd'  => $pwd
    ));
    //var_dump($stmt->fetch(PDO::FETCH_ASSOC)); die;
    // Si es igual a 1 puede entrar
    if($stmt->rowCount() != 1){
        // Si no está en la tabla principal lo intentará encontrar en el juego.
        $prefix = getPrefix($user);

        if(!$prefix){
            $msg = "Clave inválida";
        }
        else{
            // Cambio de prefijo.
            $prx = $prefix;

            $game2 = $db->prepare(
                "SELECT user_id, user_user, user_pwd,
                user_type, user_active, udata_name,
                udata_surname, udata_number_fk,
                bui_name, bui_apt
                FROM {$prx}users, {$prx}userdata, {$prx}buildings
                WHERE user_user = :user AND
                    user_pwd = :pwd AND
                    udata_user_fk = user_id AND
                    udata_number_fk = bui_id"
            );
            $rg2 = $game2->execute(array(
                'user' => $user,
                'pwd'  => $pwd
            ));

            if(!$rg2){
                // Si no logra autenticar al usuario.
                $msg = "Problema con el juego.";
                //$msg = $game2->errorInfo()[2];
            }
            else{
                $mark = 1;
                $values = $game2->fetch(PDO::FETCH_ASSOC);
            }
        }
    }
    else{
        $mark = 1;
        $values = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Continua.
    if($mark){

        // Si es igual a "0" no está activado
        if($values['user_active'] == 0){

            //$msg = "Aún no está activo. Contacte al administrador: ".EMAIL;

        }
        else{
            $status = true;
            $msg = "Sesión iniciada";

            //Se establecen los parámetros de sesión
            if(!isset($_SESSION)) session_start();

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
                case 0:
                    $_SESSION['type'] = 1;
                    $_SESSION['prefix'] = getPrefix($user);
                    break;

                default:
                    die("Ha ocurrido un error al definir el tipo de sesión.");
                    break;
            }

            // Se Fija la cookie
            if($remember === 1){
                $token = hashPassword(time().rand(0,100));
                $info = json_encode($_SESSION);
                $qc = "INSERT INTO glo_cookies
                    VALUES(null, 'remember', '$token', '$info', null)";

                try{
                    $db->exec($qc);
                    setcookie('remember', $token, time()+60*60*24, '/');
                    $cookie = $token;
                }catch(PDOStatement $err){
                    echo 'Problemas al guardar cookie: '.$err;
                    $cookie = false;
                }
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

function getQuestion(/*string*/ $email){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt = $db->prepare(
        "SELECT user_question
        FROM {$prx}users
        WHERE user_user = :email"
    );
    $stmt->bindValue('email', $email);
    $stmt->execute();

    $question = $stmt->fetchColumn();

    if(!$question){
        $msg = "No se recuperó pregunta.";
    }
    else{
        $status = true;
    }

    return json_encode(array(
        'status' => $status,
        'question' => $question)
    );
}

function setQuestionResponse($id, /*string*/ $question, /*string*/ $response){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;
    $response = hashPassword($response);

    $stmt = $db->prepare(
        "UPDATE {$prx}users
        SET user_question = :question, user_response = :response
        WHERE user_id = :id"
    );
    $stmt->execute(array(
        'question' => $question,
        'response' => $response,
        'id'    => $id
    ));

    if(!$stmt->rowCount()){
        $msg = 'Error al guardar datos.';
    }
    else{
        $status = true;
        $msg = 'Datos guardados con éxito.';
    }

    return jsonResponse($status, $msg);
}

function checkResponse(/*string*/ $question, /*string*/ $response, /*string*/ $email){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $response = hashPassword($response);
    $stmt = $db->prepare(
        "SELECT user_response FROM {$prx}users
        WHERE user_user = :email
        AND user_question = :question"
    );
    $stmt->execute(array(
        'email'=> $email,
        'question' => $question
    ));

    $origin = $stmt->fetchColumn();

    if($response == $origin){
        $status = true;
        $msg = "Correcto!";
    }else{
        $msg = "Los datos no coinciden";
    }

    return jsonResponse($status, $msg);
}

function setPassword(/*string*/ $email, /*string*/ $response, /*string*/ $pwd){
    $db = connectDb();
    $prx = $db->getPrx();

    $password = hashPassword($pwd);
    $response = hashPassword($response);

    $stmt = $db->prepare(
        "UPDATE {$prx}users
        SET user_pwd = :password
        WHERE user_user = :email
        AND user_response = :response"
    );
    $stmt->execute(array(
        'password' => $password,
        'email' => $email,
        'response' => $response
    ));

    $stmt2 = $db->prepare(
        "SELECT user_pwd
        FROM {$prx}users
        WHERE user_user = :email"
    );
    $stmt2->bindValue('email', $email);
    $stmt2->execute();

    $verif = $stmt2->fetchColumn();

    if($password === $verif){
        $status = true;
        $msg = "Clave guardada con éxito";
    }else{
        $status = false;
        $msg = "Error al guardar la clave.";
    }

    return jsonResponse($status, $msg);
}

function setPasswordFromOld(/*int*/ $id, /*string*/ $old, /*string*/ $new){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    if($old != DEF_PWD) $old = hashPassword($old);
    $new = hashPassword($new);

    $stmt1 = $db->prepare(
        "SELECT user_pwd
        FROM {$prx}users
        WHERE user_id = :id"
    );
    $stmt1->bindValue('id', $id, PDO::PARAM_INT);
    $res1 = $stmt1->execute();

    if(!$res1){
        $msg = 'Error al consultar base de datos.';
    }
    else{
        $pwd = $stmt1->fetchColumn();

        if($pwd != $old){
            $msg = 'La clave actual no coincide.';
        }
        else{
            $stmt2 = $db->prepare(
                "UPDATE {$prx}users
                SET user_pwd = :new
                WHERE user_id = :id"
            );
            $stmt2->bindValue('new', $new);
            $stmt2->bindValue('id', $id, PDO::PARAM_INT);
            $res2 = $stmt2->execute();

            if(!$res2){
                $msg = 'No se pudo guardar la nueva clave.';
            }
            else{
                $msg = 'Cambio de clave exitoso.';
                $status = true;
            }
        }
    }

    return jsonResponse($status, $msg);
}

function checkEmail(/*string*/ $email){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt = $db->prepare(
        "SELECT user_id
        FROM {$prx}users
        WHERE user_user = :email"
    );
    $stmt->bindValue('email', $email);
    $res = $stmt->execute();

    if(!$res){
        $msg = "Error al consultar la base de datos";
    }
    else{
        if($stmt->rowCount() != 1){
            $msg = "El usuario no existe.";
        }
        else{
            $status = true;
        }
    }

    return jsonResponse($status, $msg);
}

function checkOldPassword(/*int*/ $id){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt = $db->prepare(
        "SELECT user_pwd
        FROM {$prx}users
        WHERE user_id = :id"
    );
    $stmt->bindValue('id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if(!$stmt){
        $msg = "No se pudo recuperar la clave.";
    }
    else{
        $pwd = $stmt->fetchColumn();
        if($pwd != DEF_PWD){
            $msg = 'Es diferente.';
        }
        else{
            $status = true;
            $msg = array('old' => $pwd);
        }
    }

    return jsonResponse($status, $msg);
}
