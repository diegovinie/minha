<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

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

function setUsersData($prx, $apts){
    $db = connectDb();

    $stmt = $db->prepare(
        "INSERT INTO `{$prx}users`
        VALUES(
            NULL,
            :user,
            :pwd,
            :question,
            :response,
            :type,
            :active,
            'demo',
            NULL)"
    );

    $stmt->bindParam('user', $email);
    $stmt->bindParam('pwd', $pwd);
    $stmt->bindParam('question', $question);
    $stmt->bindParam('response', $resHashed);
    $stmt->bindParam('type', $type);
    $stmt->bindParam('active', $active);

    $stmt2 = $db->prepare(
        "SELECT user_id AS 'userid', apt_id AS 'aptid'
        FROM {$prx}users, {$prx}apartments
        WHERE user_user = :email
        AND apt_edf = :edf
        AND apt_name = :name"
    );
    $stmt2->bindParam('email', $email);
    $stmt2->bindParam('name', $aptname);
    $stmt2->bindParam('edf', $aptedf);

    $stmt3 = $db->prepare(
        "INSERT INTO `{$prx}userdata`
        VALUES (
            NULL,
            :name,
            :surname,
            :ci,
            :cel,
            :cond,
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
    $stmt3->bindParam('gender', $gender);
    $stmt3->bindParam('nac', $nac);
    $stmt3->bindParam('aptid', $aptid);
    $stmt3->bindParam('userid', $userid);

    foreach ($apts as $apt) {

        if(isset($apt['users'])){

            foreach ($apt['users'] as $user) {

                extract($user);
                $resHashed = md5($response);
                //$quest = $question? $question : '';

                $exe1 = $stmt->execute();

                if(!$exe1){
                    print_r($stmt->errorInfo());
                    return false;
                }
                else{
                    $aptname = $apt['name'];
                    $aptedf = $apt['edf'];


                    $exe2 = $stmt2->execute();

                    if(!$exe2){
                        print_r($stmt2->errorInfo());
                        return false;
                    }
                    else{
                        $res2 = $stmt2->fetch(PDO::FETCH_ASSOC);

                        extract($res2);

                        $exe3 = $stmt3->execute();

                        if(!$exe3){
                            echo $stmt3->errorInfo()[2];
                            print_r($user);
                            return false;
                        }
                    }
                }
            }
        }
    }
    return true;
}
