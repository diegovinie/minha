<?php
/*
 *
 */
defined('_EXE') or die('Acceso restringido');

$db = include ROOTDIR.'/models/db.php';

// Repetida en users/models/users.php
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
