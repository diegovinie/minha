<?php

include_once ROOTDIR.'/models/db.php';

function addCurrentUser($prx, $email, $pwd, $name, $surname, $edf, $apt){
    $db = connectDb();

    include ROOTDIR.'/models/hashpassword.php';
    $password = hashPassword($pwd);

    $stmt = $db->prepare(
        "INSERT INTO {$prx}users
        VALUES (
            NULL,
            :email,
            :password,
            NULL,
            NULL,
            0,
            1,
            NULL,
            NULL
        )"
    );

    $exe = $stmt->execute(array(
        'email' => $email,
        'password'   => $password
    ));

    if(!$exe){
        echo $stmt->errorInfo()[2];
        return false;
    }
    else{
        $stmt2 = $db->prepare(
            "SELECT user_id, bui_id
            FROM {$prx}users, {$prx}buildings
            WHERE user_user = :email
            AND bui_apt = :apt"
        );

        $exe2 = $stmt2->execute(array(
            'email' => $email,
            'apt'   => $apt
        ));

        if(!$exe2){
            echo $db->errorInfo()[2];
            return false;
        }
        else{
            $data = $stmt2->fetch(PDO::FETCH_ASSOC);
            extract($data);

            $stmt3 = $db->prepare(
                "INSERT INTO {$prx}userdata
                VALUES(
                    NULL,
                    :name,
                    :surname,
                    NULL,
                    NULL,
                    1,
                    NULL,
                    :bui_id,
                    :user_id
                )"
            );
            $exe3 = $stmt3->execute(array(
                'name' => $name,
                'surname' => $surname,
                'bui_id' => $bui_id,
                'user_id' => $user_id
            ));

            if(!$exe3){
                echo $stmt3->errorInfo()[2];
                return false;
            }
            else{
                return true;
            }
        }
    }
}

function addGameTable($user){
    $db = connectDb();

    $stmt = $db->prepare(
        "INSERT INTO pri_game
        (gam_id, gam_user, gam_ts)
        VALUES (NULL, :user, NULL)"
    );
    $stmt->bindValue('user', $user);
    $res = $stmt->execute();

    if(!$res){
        echo $db->errorInfo()[2];
        return false;
    }
    else{
        return true;
    }
}
