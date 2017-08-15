<?php
/* components/users/models/users.php
 *
 * Modelo
 * Retorna un json (status, msg, [otros])
 */

defined('_EXE') or die('Acceso restringido');

$db = include ROOTDIR.'/models/db.php';
include ROOTDIR.'/models/tables.php';


function getUsers($bui){
    global $db;
    $stmt = $db->query(
        "SELECT user_id AS 'id', udata_name AS 'Nombre',
        udata_surname AS 'Apellido', udata_ci AS 'C.I.',
        bui_apt AS 'Apartamento', user_user AS 'Correo',
        CASE user_type
        WHEN 1 THEN 'Administrador'
        WHEN 2 THEN 'Usuario'
        ELSE 'Indeterminado' END AS 'Tipo de Usuario'
        FROM users, userdata, buildings
        WHERE udata_user_fk = user_id AND udata_number_fk = bui_id
        AND user_active = 1 AND bui_name = '$bui'"
    );

    if($stmt){
        $table = setTheadTbodyFromPDO($stmt);
        $status = true;

    }else{
        $status = false;

    }

    $response = array(
        'status' => $status,
        'table' => $table
    );
    return json_encode($response);
}

function getPendingUsers($bui){
    global $db;
    $stmt = $db->query(
        "SELECT user_id AS 'id', udata_name AS 'Nombre', udata_surname AS 'Apellido',
        udata_ci AS 'C.I.',  bui_apt AS 'Apartamento',
        user_user AS 'Correo',
        CASE user_type
        WHEN 1 THEN 'Administrador'
        WHEN 2 THEN 'Usuario'
        ELSE 'Indeterminado' END AS 'Tipo de Usuario'
        FROM users, userdata, buildings
        WHERE udata_user_fk = user_id AND udata_number_fk = bui_id
        AND user_active = 0 AND bui_name = '$bui'"
    );

    if($stmt){
        $table = setTheadTbodyFromPDO($stmt);
        $status = true;

    }else{
        $status = false;

    }

    $response = array(
        'status' => $status,
        'table' => $table
    );
    return json_encode($response);
}

function setUserActive($id){

    global $db;
    $exe = $db->exec(
        "UPDATE users SET user_active = 1
        WHERE user_id = $id"
    );

    if($exe){
        $status = true;
        $msg = 'Activado con éxito.';
    }else{
        $status = false;
        $msg = 'Error al actualizar';
    }

    return json_encode(array(
        'status' => $status,
        'msg' => $msg
    ));
}

function deleteUser($id){
    global $db;

    $exe1 = $db->exec(
        "DELETE FROM userdata
        WHERE udata_user_fk = $id"
    );

    if(!$exe1){
        $status = false;
        $msg = 'Error al borrar metadatos';
    }
    else{
        // Borrar de la tabla users
        $exe2 = $db->exec(
            "DELETE FROM users
            WHERE user_id = $id"
        );

        if(!$exe2){
            $status = false;
            $msg = 'Error al borrar el usuario';
        }
        else{
            // Finalización exitosa
            $status = true;
            $msg = 'Operación realizada con éxito';
        }
    }

    return json_encode(array(
        'status' => $status,
        'msg' => $msg
    ));
}

// Repetida de security/models/createuser.php
function createUser($array){
    global $db;
    explode($array);

    $active = PRUEBA == true? 1 : 0;
    $type = PRUEBA == true? 1 : 2;

    // Verifica que no exista el usuario
    $stmt1 = $db->query(
        "SELECT user_id FROM users
        WHERE user_user = '$email'"
    );

    if(!$stmt1->rowCount() === 0){
        $status = false;
        $msg = 'El usuario ya está registrado';
    }
    else{
        //Registra en users usuario y clave como inactivo
        $pwd = md5($pwd);
        $ex1 = $db->exec(
            "INSERT INTO users
            VALUES (NULL, '$email', '$pwd', '', '', $type, $active,
            'register:$email', NULL)"
        );

        if(!$ex1){
            $status = false;
            $msg = 'Error al insertar usuario.';
        }
        else{
            // Solicitando claves foráneas
            $stmt2 = $db->query(
                "SELECT bui_id, user_id FROM users, buildings
                WHERE user_user = '$email' AND bui_name = '$edf'
                AND bui_apt = '$apt'"
            );

            if(!$stmt2){
                $status = false;
                $msg = 'Error al solicitar claves.';
            }
            else{
                // Preparar array de fk e insertar en userdata
                foreach ($stmt2->fetchAll(PDO::FETCH_NUM) as $key => $value) {
                    $fk[$key] = $value;
                }

                $ex3 = $db->exec(
                    "INSERT INTO userdata
                    VALUES (NULL, '$name', '$surname', '$ci',
                    NULL, $cond, 'M', $fk[0], $fk[1])"
                );

                if(!$ex3){
                    $status = false;
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

    return json_encode(array(
        'status' => $status,
        'msg'   => $msg
    ));
}
