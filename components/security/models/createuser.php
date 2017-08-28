<?php
/* components/security/models/createuser.php
 *
 */
defined('_EXE') or die('Acceso restringido');

include_once ROOTDIR.'/models/db.php';
include_once ROOTDIR.'/models/modelresponse.php';

// Repetida en users/models/users.php
function createUser(    /*string*/ $name,
                        /*string*/ $surname,
                        /*string*/ $email,
                        /*string*/ $edf,
                        /*string*/ $apt,
                        /*int*/ $cond,
                        /*int*/ $role,
                        /*int*/ $accepted,
                        /*string*/ $pwd){

    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    // Verifica que no exista el usuario
    $stmt1 = $db->prepare(
        "SELECT user_id
        FROM {$prx}users
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
            VALUES (
                NULL,
                :email,
                :pwd,
                NULL,
                NULL,
                :active,
                'system',
                NULL)"
        );
        $res2 = $stmt2->execute(array(
            'email' => $email,
            'pwd' => $pwd,
            'active' => $active
        ));

        if(!$res2){
            $msg = 'Error al insertar usuario.';
        }
        else{
            // Solicitando claves foráneas
            $stmt3 = $db->prepare(
                "SELECT bui_id, user_id
                FROM glo_users, {$prx}apartments
                WHERE user_user = :email
                    AND apt_name = :apt
                    AND apt_edf = :edf"
            );
            $stmt3->execute(array(
                'email' => $email,
                'edf'   => $edf,
                'apt'   => $apt
            ));

            if($stmt3->rowCount() != 1){
                $msg = 'Error duante la creación.';
            }
            else{
                // Preparar array de fk e insertar en userdata
                foreach ($stmt3->fetch(PDO::FETCH_NUM) as $key => $value) {
                    $fk[$key] = $value;
                }

                $stmt4 = $db->prepare(
                    "INSERT INTO {$prx}habitants
                    VALUES (
                        NULL,
                        :name,
                        :surname,
                        NULL,
                        NULL,
                        :cond,
                        :role,
                        :accepted,
                        NULL,
                        NULL,
                        :aptid,
                        :userid)"
                );
                $res4 = $stmt4->execute(array(
                    'name'  => $name,
                    'surname' => $surname,
                    'cond'  => $cond,
                    'accepted' => $accepted,
                    'role'    => $role,
                    'aptid' => $fk[0],
                    'userid' => $fk[1]
                ));

                if(!$res4){
                    $msg = 'Error al guardar metadatos.';
                }
                else{
                    // Operación finalizada con éxito;
                    $status = true;
                    $msg = 'Usuario creado con éxito.';
                }
            }
        }
    }

    return jsonResponse($status, $msg);
}
