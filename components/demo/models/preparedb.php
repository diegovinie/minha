<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function setBuildingsData($prx, $bui){
    $db = connectDb();

    $stmt = $db->prepare(
        "INSERT INTO {$prx}buildings
        VALUES (
            NULL,
            :name,
            :apt,
            0,
            :w,
            :assigned,
            :occupied,
            :notes
        )"
    );

    foreach ($bui as $id => $aptarr) {
        $stmt->bindParam('name', $name);
        $stmt->bindParam('apt', $apt);
        $stmt->bindParam('w', $weight);
        $stmt->bindParam('assigned', $assigned, PDO::PARAM_INT);
        $stmt->bindParam('occupied', $occupied, PDO::PARAM_INT);
        $stmt->bindParam('notes', $notes);

        extract($aptarr);

        $exe = $stmt->execute();

        if(!$exe){
            echo $stmt->errorInfo()[2];
            return false;
        }
    }

    return true;
}

function setUsersData($prx, $bui){
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
        "SELECT user_id AS 'userid', bui_id AS 'buiid'
        FROM {$prx}users, {$prx}buildings
        WHERE user_user = :email
        AND bui_apt = :aptname"
    );
    $stmt2->bindParam('email', $email);
    $stmt2->bindParam('aptname', $aptname);

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
            :buiid,
            :userid)"
    );
    $stmt3->bindParam('name', $name);
    $stmt3->bindParam('surname', $surname);
    $stmt3->bindParam('ci', $ci);
    $stmt3->bindParam('cel', $cel);
    $stmt3->bindParam('cond', $cond);
    $stmt3->bindParam('gender', $gender);
    $stmt3->bindParam('buiid', $buiid);
    $stmt3->bindParam('userid', $userid);

    foreach ($bui as $apt) {

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
                    $aptname = $apt['apt'];

                    $exe2 = $stmt2->execute();

                    if(!$exe2){
                        print_r($stmt2->errorInfo());
                        return false;
                    }
                    else{
                        $res2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                        //print_r($res2); die;
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
