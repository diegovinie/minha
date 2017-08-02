<?php
/*
 *
 */
defined('_EXE') or die('Acceso restringido');

$db = include ROOTDIR.'/models/db.php';

function createUser($array){
    global $db;
    explode($array);

    $stmt1 = $db->query(
        "SELECT user_id FROM users
        WHERE user_user = '$email'"
    );
    $active = PRUEBA == true? 1 : 0;
    $type = PRUEBA == true? 1 : 2;

    if($stmt1->rowCount() === 0){
        //Registra en users usuario y clave como inactivo
        $pwd = md5($pwd);
        $ex1 = $db->exec(
            "INSERT INTO users
            VALUES (NULL, '$email', '$pwd', '', '', $type, $active,
            'register:$email', NULL)"
        );

        $stmt2 = $db->query(
            "SELECT bui_id, user_id FROM users, buildings
            WHERE user_user = '$email' AND bui_name = '$edf' AND bui_apt = '$apt'"
        );

        foreach ($stmt2->fetch() as $key => $value) {
            $fk[$key] = $value;
        }


    }

}
