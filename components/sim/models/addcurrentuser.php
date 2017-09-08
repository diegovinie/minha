<?php

include_once ROOTDIR.'/models/db.php';

function getLastUserId($email){
    $db = connectDb();

    $stmt = $db->prepare(
        "SELECT user_id
        FROM glo_users
        WHERE user_user = :email"
    );
    $stmt->bindValue('email', $email);

    $res = $stmt->execute();

    if(!$res || $stmt->rowCount() != 1){
        echo $stmt->errorInfo()[2];
        return false;
    }

    return $stmt->fetchColumn();
}

function addCurrentUser($email, $pwd){
    $db = connectDb();

    include_once ROOTDIR.'/models/hashpassword.php';
    $password = hashPassword($pwd);

    $stmt = $db->prepare(
        "INSERT INTO glo_users
        (user_user, user_pwd,   user_active)
        VALUES
        (:email,    :password,  0)"
    );

    $res = $stmt->execute(array(
        'email'    => $email,
        'password' => $password
    ));

    if(!$res){
        echo $stmt->errorInfo()[2];
        return false;
    }

    return true;
}

function addUserUsers($email, $pwd){
    $db = connectDb();

    $userid = getLastUserId($email);

    if(!$userid){

        $res1 = addCurrentUser($email, $pwd);

        if(!$res1){
            echo "Imposible registrar usuario $email.";
            return false;
        }

        $userid = getLastUserId($email);
    }

    return $userid;
}

function addUserHabitants($prx, $userid, $simid, $email, $name, $surname, $edf, $apt){
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
         :name,         :surname,       1,            1,
         1,             :aptid,         :email,       :userid)"
    );

    $exe2 = $stmt2->execute(array(
        'name' => $name,
        'surname' => $surname,
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

function addUserSimulator($email){
    $db = connectDb();

    $userid = getLastUserId($email);

    if(!$userid){
        echo "Error al recuperar id en simulator";
        return false;
    }

    $stmt1 = $db->prepare(
        "INSERT INTO glo_simulator
        (sim_user,   sim_user_fk)
        VALUES
        (:user,      :userid)"
    );
    $stmt1->bindValue('user', $email);
    $stmt1->bindValue('userid', $userid, PDO::PARAM_INT);

    $res1 = $stmt1->execute();

    if(!$res1){
        echo $db->errorInfo()[2];
        return false;
    }

    return true;
}

function getLastUserSimId($email){
    $db = connectDb();

    $stmt = $db->prepare(
        "SELECT sim_id
        FROM glo_simulator
        WHERE sim_user = :email
        ORDER BY sim_id DESC
        LIMIT 1"
    );
    $stmt->bindValue('email', $email);

    $res = $stmt->execute();

    if(!$res){
        echo $db->errorInfo()[2];
        return false;
    }

    return $stmt->fetchColumn();
}

function getHabitantId($userId){
    $db = connectDb();
    $prx = 's1_';

    $stmt = $db->query(
        "SELECT hab_id
        FROM {$prx}habitants
        WHERE hab_user_fk
        LIMIT 1"
    );

    return $stmt->fetchColumn();
}
