<?php
/* components/security/models/createuser.php
 *
 */
defined('_EXE') or die('Acceso restringido');

include_once ROOTDIR.'/models/db.php';
include_once ROOTDIR.'/models/modelresponse.php';

// Repetida en users/models/users.php
// Modificada 09/09/17
function createUser(    /*string*/ $name,
                        /*string*/ $surname,
                        /*string*/ $email,
                        /*string*/ $edf,
                        /*string*/ $apt,
                        /*int*/ $cond,
                        /*int*/ $role,
                        /*int*/ $accepted,
                        /*string*/ $pwd)
{

    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    // Verifica que no exista el usuario
    $stmt1 = $db->prepare(
        "SELECT user_id
        FROM glo_users
        WHERE user_user = :email"
    );
    $stmt1->bindValue('email', $email);
    $stmt1->execute();

    if($stmt1->rowCount() != 0){
        $msg = 'El usuario ya está registrado';
    }
    else{
        //Registra en users usuario y clave como inactivo
        $pwd = md5($pwd);
        $stmt2 = $db->prepare(
            "INSERT INTO glo_users
            (user_user,     user_pwd,
             user_active,   user_creator)
            VALUES
            (:email,        :pwd,
             1,             'selfregister')"
        );
        $stmt2->bindValue('email', $email);
        $stmt2->bindValue('pwd', $pwd);

        $res2 = $stmt2->execute();

        if(!$res2){
            $msg = 'Error al insertar usuario.';
        }
        else{

        $res3 = addUserHabitants(   $prx='glo_',
                                    $userid,
                                    $simid=1,
                                    $email,
                                    $name,
                                    $surname,
                                    $cond,
                                    $role,
                                    $edf,
                                    $apt);

            if(!$res3){
                $msg = 'Error duante la creación.';
            }
            else{
                // Operación finalizada con éxito;
                $status = true;
                $msg = 'Usuario creado con éxito.';
            }
        }
    }

    return jsonResponse($status, $msg);
}

/* Copiada de sim/models/addcurrentuser.php
 *
 */
function addUserHabitants(  /*string*/ $prx,
                            /*int*/ $userid,
                            /*int*/ $simid,
                            /*string*/ $email,
                            /*string*/ $name,
                            /*string*/ $surname,
                            /*int*/ $cond,
                            /*int*/ $role,
                            /*string*/ $edf,
                            /*string*/ $apt)
{
    $db = connectDb();

    $userid = getLastUserId($email);

    $stmt1 = $db->prepare(
        "SELECT apt_id
        FROM glo_buildings
            INNER JOIN {$prx}apartments ON apt_bui_fk = bui_id
        WHERE bui_edf = :edf
            AND apt_name = :apt
            AND apt_sim_fk = :simid"
    );

    $res1 = $stmt1->execute(array(
        'apt'   => $apt,
        'edf'   => $edf,
        'simid' => $simid
    ));

    if(!$res1){
        echo $stmt1->errorInfo()[2];
        return false;
    }

    $aptid = $stmt1->fetchColumn();

    $stmt2 = $db->prepare(
        "INSERT INTO {$prx}habitants
        (hab_name,      hab_surname,    hab_cond,     hab_role,
         hab_accepted,  hab_apt_fk,     hab_email,    hab_user_fk)
        VALUES(
         :name,         :surname,       :cond,        :role,
         1,             :aptid,         :email,       :userid)"
    );

    $exe2 = $stmt2->execute(array(
        'name' => $name,
        'surname' => $surname,
        'cond' => $cond,
        'role' => $role,
        'aptid' => $aptid,
        'userid' => $userid,
        'email'  => $email
    ));

    if(!$exe2){
        echo $stmt2->errorInfo()[2];
        return false;
    }

    return true;
}
