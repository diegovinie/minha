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

function checkUser(/*string*/ $user, /*string*/ $pwd, /*int*/ $remember=null){
    $db = connectDb();

    $prefix = getPrefix($user);

    $prx = $prefix? $prefix : 'pri_';

    $status = false;
    $cookie = false;

    if($pwd != DEF_PWD) $pwd = hashPassword($pwd);
    $stmt = $db->prepare(
        "SELECT user_id, user_user,
            user_pwd,   user_active,
            hab_role,   hab_accepted,
            hab_name,   hab_id,
            hab_apt_fk, hab_surname,
            apt_edf,    apt_name,
            apt_id
        FROM glo_users,
            {$prx}habitants,
            {$prx}apartments
        WHERE user_user = :user
            AND user_pwd = :pwd
            AND hab_user_fk = user_id
            AND hab_apt_fk = apt_id"
    );

    $res = $stmt->execute(array(
        'user' => $user,
        'pwd'  => $pwd
    ));

    //var_dump($stmt->fetch(PDO::FETCH_ASSOC)); die;
    // Si es igual a 1 puede entrar
    if($stmt->rowCount() != 1){
        $msg = "Usuario o clave incorrecto.";
    }
    else{
        $values = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si el usuario está activo
        if(!$values['user_active']){

            $msg = "Contacte al administrador.";
        }
        else{
            // Si el habitante ha sido aceptado
            if(!$values['hab_accepted']){

                $msg = "Su cuenta en breve será activada.";
            }
            else{
                $status = true;
                $msg = "Sesión iniciada";

                //Se establecen los parámetros de sesión
                if(!isset($_SESSION)) session_start();

                $_SESSION['user_id'] = $values['user_id'];
                $_SESSION['user'] = $user;
                $_SESSION['status'] = 'active';
                $_SESSION['name'] = $values['hab_name'];
                $_SESSION['surname'] = $values['hab_surname'];
                //$_SESSION['val'] = $values['user_active'];
                $_SESSION['apt_id'] = $values['apt_id'];
                $_SESSION['hab_id'] = $values['hab_id'];
                $_SESSION['apt'] = $values['apt_name'];
                $_SESSION['edf'] = $values['apt_edf'];

                //Se define que tipo de usuario es
                switch ($values['hab_role']) {
                    case 1:
                        $_SESSION['role'] = 1;
                        //echo "ir a administrador";
                        break;
                    case 2:
                        $_SESSION['role'] = 2;
                        //echo "ir a usuario";
                        break;
                    case 0:
                        $_SESSION['role'] = 0;
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
    }

    $response = array(
        'status'    => $status,
        'msg'       => $msg,
        'session'   => $cookie);

    return json_encode($response);
}

function getQuestion(/*string*/ $email){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt = $db->prepare(
        "SELECT user_question
        FROM glo_users
        WHERE user_user = :email"
    );
    $stmt->bindValue('email', $email);
    $res = $stmt->execute();

    if(!$res){
        $msg = "No se recuperó pregunta.";
    }
    else{
        $status = true;
        $msg = $stmt->fetchColumn();
    }

    return json_encode(array(
        'status' => $status,
        'question' => $msg)
    );
}

function setQuestionResponse($id, /*string*/ $question, /*string*/ $response){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;
    $response = hashPassword($response);

    $stmt = $db->prepare(
        "UPDATE glo_users
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
        "SELECT user_response
        FROM glo_users
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
        "UPDATE glo_users
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
        FROM glo_users
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
        FROM glo_users
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
                "UPDATE glo_users
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
        FROM glo_users
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
        FROM glo_users
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
