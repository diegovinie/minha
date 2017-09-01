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

function addUserHabitants($prx, $email, $name, $surname, $edf, $apt){
    $db = connectDb();

    $userid = getLastUserId($email);

    $stmt1 = $db->prepare(
        "SELECT user_id, apt_id
        FROM glo_users,
            {$prx}apartments
        WHERE user_user = :email
            AND apt_name = :apt
            AND apt_edf = :edf"
    );

    $res1 = $stmt1->execute(array(
        'email' => $email,
        'apt'   => $apt,
        'edf'   => $edf
    ));

    if(!$res1){
        echo $stmt1->errorInfo()[2];
        return false;
    }

    $res1 = $stmt1->fetch(PDO::FETCH_ASSOC);

    extract($res1);

    $stmt2 = $db->prepare(
        "INSERT INTO {$prx}habitants
        (hab_name,      hab_surname,    hab_cond,     hab_role,
         hab_accepted,  hab_apt_fk,     hab_user_fk,  hab_email)
        VALUES(
            :name,      :surname,        1,           0,
            1,          :aptid,          :userid,     :email)"
    );

    $exe2 = $stmt2->execute(array(
        'name' => $name,
        'surname' => $surname,
        'aptid' => $apt_id,
        'userid' => $user_id,
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
