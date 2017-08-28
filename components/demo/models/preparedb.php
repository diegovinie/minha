<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function addGetUserId($simEmail){
    $db = connectDb();

    ///// Preparación de consultas

    // Inserta el simulador en users
    $stmt = $db->prepare(
        "INSERT INTO `glo_users`
        VALUES(
            NULL,
            :user,
            :pwd,
            NULL,
            NULL,
            1,
            'system',
            NULL)"
    );
    $stmt->bindValue('user', $simEmail);
    $stmt->bindValue('pwd', DEF_PWD);

    // Selecciona el id del simulador en users
    $stmt1 = $db->prepare(
        "SELECT user_id
        FROM glo_users
        ORDER BY user_id DESC
        LIMIT 1"
    );

    ///// Inicio de la ejecución

    $res = $stmt->execute();

    if(!$res){
        print_r($stmt->errorInfo());
        return false;
    }

    $res1 = $stmt1->execute();

    if(!$res1){
        print_r($stmt1->errorInfo());
        return false;
    }

    return $userid = $stmt1->fetchColumn();
}

function setApartmentsData($prx, $apts){
    $db = connectDb();

    $st = $db->prepare(
        "SELECT bui_id
        FROM glo_buildings
        WHERE bui_edf = :edf"
    );
    $st->bindParam('edf', $edf);


    $stmt = $db->prepare(
        "INSERT INTO {$prx}apartments
        VALUES (
            NULL,
            :name,
            :buiid,
            :edf,
            0,
            :w,
            :assigned,
            :occupied,
            :notes
        )"
    );

    foreach ($apts as $id => $apt) {
        $stmt->bindParam('name', $name);
        $stmt->bindParam('buiid', $buiid);
        $stmt->bindParam('edf', $edf);
        $stmt->bindParam('w', $weight);
        $stmt->bindParam('assigned', $assigned, PDO::PARAM_INT);
        $stmt->bindParam('occupied', $occupied, PDO::PARAM_INT);
        $stmt->bindParam('notes', $notes);

        extract($apt);

        $qry = $st->execute();

        $buiid = $st->fetchColumn();

        $exe = $stmt->execute();

        if(!$exe){
            echo $stmt->errorInfo()[2];
            return false;
        }
    }

    return true;
}

function setHabitantsData($prx, $cmty, $email){
    $db = connectDb();

    ///// Preparación de consultas

    // Selecciona el id del apartamento
    $stmt2 = $db->prepare(
        "SELECT apt_id AS 'aptid'
        FROM {$prx}apartments
        WHERE apt_edf = :edf
        AND apt_name = :apt"
    );
    $stmt2->bindParam('apt', $aptname);
    $stmt2->bindParam('edf', $aptedf);

    // Inserta datos en habitants
    $stmt3 = $db->prepare(
        "INSERT INTO `{$prx}habitants`
        VALUES (
            NULL,
            :name,
            :surname,
            :ci,
            :cel,
            :cond,
            :role,
            :accepted,
            :gender,
            :nac,
            :aptid,
            :userid)"
    );
    $stmt3->bindParam('name', $name);
    $stmt3->bindParam('surname', $surname);
    $stmt3->bindParam('ci', $ci);
    $stmt3->bindParam('cel', $cel);
    $stmt3->bindParam('cond', $cond);
    $stmt3->bindParam('role', $role);
    $stmt3->bindParam('accepted', $accepted);
    $stmt3->bindParam('gender', $gender);
    $stmt3->bindParam('nac', $nac);
    $stmt3->bindParam('aptid', $aptid);
    $stmt3->bindParam('userid', $userid);

    ////// Inicio de la ejecución

    $userid = addGetUserId($email);

    foreach ($cmty as $apt) {

        if(isset($apt['habs'])){

            foreach ($apt['habs'] as $hab) {

                extract($hab);

                $aptname = $apt['name'];
                $aptedf = $apt['edf'];

                $exe2 = $stmt2->execute();

                if(!$exe2){
                    echo $stmt2->errorInfo()[2];
                    return false;
                }

                $res2 = $stmt2->fetch(PDO::FETCH_ASSOC);

                extract($res2);

                $exe3 = $stmt3->execute();

                if(!$exe3){
                    echo $stmt3->errorInfo()[2];
                    return false;
                }
            }
        }
    }

    return true;
}
