<?php
/* components/users/models/users.php
 *
 * Modelo
 * Retorna un json (status, msg, [otros])
 */

defined('_EXE') or die('Acceso restringido');

include_once ROOTDIR.'/models/db.php';
include_once ROOTDIR.'/models/tables.php';
include_once ROOTDIR.'/models/modelresponse.php';


function getHabitants(/*string*/ $edf){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt = $db->prepare(
        "SELECT hab_id AS 'id',
            hab_name AS 'Nombre',
            hab_surname AS 'Apellido',
            hab_ci AS 'C.I.',
            apt_name AS 'Apartamento',
            hab_email AS 'Correo',
        CASE hab_role
            WHEN 0 THEN 'Jugador'
            WHEN 1 THEN 'Administrador'
            WHEN 2 THEN 'Usuario'
            ELSE 'Indeterminado' END AS 'Tipo de Usuario'
        FROM {$prx}habitants
            INNER JOIN {$prx}apartments ON hab_apt_fk = apt_id
        WHERE apt_edf = :edf
            AND hab_accepted = 1"
    );

    $stmt->bindValue('edf', $edf);
    $res = $stmt->execute();

    if(!$res){
        $msg = $stmt->errorInfo()[2];

    }else{
        $msg = setTheadTbodyFromPDO($stmt);

        $status = true;
    }

    return jsonTableResponse($status, $msg);
}

function getPendingUsers(/*string*/ $edf){

    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt = $db->prepare(
        "SELECT hab_id AS 'id',
            hab_name AS 'Nombre',
            hab_surname AS 'Apellido',
            hab_ci AS 'C.I.',
            apt_name AS 'Apartamento',
            hab_email AS 'Correo',
        CASE hab_role
            WHEN 0 THEN 'Jugador'
            WHEN 1 THEN 'Administrador'
            WHEN 2 THEN 'Usuario'
            ELSE 'Indeterminado' END AS 'Tipo de Usuario'
        FROM {$prx}habitants
            INNER JOIN {$prx}apartments ON hab_apt_fk = apt_id
        WHERE apt_edf = :edf
            AND hab_accepted = 0"
    );

    $stmt->bindValue('edf', $edf);
    $res = $stmt->execute();

    if(!$res){
        $msg = $stmt->errorInfo()[2];
        die($msg);

    }else{
        $msg = setTheadTbodyFromPDO($stmt);
        $status = true;
    }

    return jsonTableResponse($status, $msg);
}

function acceptHabitant(/*int*/ $habid){
    $db = connectDb();
    $prx = $db->getPrx();

    $status = false;

    $stmt = $db->prepare(
        "UPDATE {$prx}habitants
        SET hab_accepted = 1
        WHERE hab_id = :habid"
    );
    $stmt->bindValue('habid', $habid, PDO::PARAM_INT);
    $res = $stmt->execute();

    if($res){
        $status = true;
        $msg = 'Activado con éxito.';
    }else{
        $msg = 'Error al actualizar';
    }

    return jsonResponse($status, $msg);
}

// REVISAR
function deleteHabitant(/*int*/ $habid){
    $db = connectDb();
    $prx = $db->getPrx();

    $stmt1 = $db->prepare(
        "DELETE FROM {$prx}habitants
        WHERE hab_id = :habid"
    );
    $stmt1->bindValue('habid', $habid, PDO::PARAM_INT);
    $res1 = $stmt1->execute();

    if(!$res1){
        $status = false;
        $msg = 'Error al borrar metadatos';
    }
    else{
        // Borrar de la tabla users
        //$stmt2 = $db->prepare(
            //"DELETE FROM glo_users
            //WHERE user_id = :id"
        //);
        //$stmt2->bindValue('id', $id, PDO::PARAM_INT);
        //$res2 = $stmt2->execute();

        //if(!$res2){
        //    $status = false;
        //    $msg = 'Error al borrar el usuario';
        //}
        //else{
        //    // Finalización exitosa
            $status = true;
            $msg = 'Operación realizada con éxito';
        //}
    }

    return jsonResponse($status, $msg);
}

// Repetida de security/models/createuser.php
function createUser(/*array*/ $array){
    $db = connectDb();
    $prx = $db->getPrx();

    explode($array);

    $active = PRUEBA == true? 1 : 0;
    $type = PRUEBA == true? 1 : 2;

    // Verifica que no exista el usuario
    $stmt1 = $db->query(
        "SELECT user_id
        FROM {$prx}users
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
            "INSERT INTO {$prx}users
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
                "SELECT bui_id, user_id
                FROM {$prx}users, {$prx}buildings
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
                    "INSERT INTO {$prx}userdata
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

    return jsonResponse($status, $msg);
}
