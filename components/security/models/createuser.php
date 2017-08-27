<?php
/* components/security/models/createuser.php
 *
 */
defined('_EXE') or die('Acceso restringido');

include ROOTDIR.'/models/db.php';
include ROOTDIR.'/models/modelresponse.php';

// Repetida en users/models/users.php
function createUser(    /*string*/ $name,
                        /*string*/ $surname,
                        /*string*/ $email,
                        /*string*/ $edf,
                        /*string*/ $apt,
                        /*int*/ $cond,
                        /*int*/ $type,
                        /*int*/ $active,
                        /*string*/ $pwd){

    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $active = isset($active)? $active : PRUEBA == true? 1 : 0;
    $type = isset($type)? $type : PRUEBA == true? 1 : 2;

    // Verifica que no exista el usuario
    $stmt1 = $db->prepare(
        "SELECT user_id FROM {$prx}users
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
            "INSERT INTO users
            VALUES (
                NULL,
                :email,
                :pwd,
                '',
                '',
                :type,
                :active,
                'register: auto',
                NULL)"
        );
        $res2 = $stmt2->execute(array(
            'email' => $email,
            'pwd' => $pwd,
            'type' => $type,
            'active' => $active
        ));

        if(!$res2){
            $msg = 'Error al insertar usuario.';
        }
        else{
            // Solicitando claves foráneas
            $stmt3 = $db->prepare(
                "SELECT bui_id, user_id
                FROM {$prx}users, {$prx}buildings
                WHERE user_user = :email
                AND bui_name = :edf
                AND bui_apt = :apt"
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
                    "INSERT INTO {$prx}userdata
                    VALUES (
                        NULL,
                        :name,
                        :surname,
                        :ci,
                        NULL,
                        :cond,
                        'M',
                        :buiid,
                        :userid)"
                );
                $res4 = $stmt4->execute(array(
                    'name'  => $name,
                    'surname' => $surname,
                    'ci'    => isset($ci)? $ci : '',
                    'cond'  => $cond,
                    'buiid' => $fk[0],
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
