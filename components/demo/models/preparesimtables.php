<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function setDataActypesTable(){
    $db = connectDb();
    //$db->exec("SET FOREIGN_KEY_CHECKS=0");

    //$db->exec("TRUNCATE sim_actypes");

    $json = file_get_contents(APPDIR."database/datafixtures/actypes.json");
    $actypes = json_decode($json, true);

    $stmt = $db->prepare(
        "INSERT INTO sim_actypes
        VALUES (
            :id,
            :name,
            :op)"
    );
    $stmt->bindParam('name', $name);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->bindParam('op', $op);

    foreach($actypes as $actype){
        extract($actype);

        $exe = $stmt->execute();

        if(!$exe){
            echo $stmt->errorInfo()[2];
            return false;
        }
    }
    $db->exec("SET FOREIGN_KEY_CHECKS=1");

    return true;
}

function setDataActivitiesTable(){
    $db = connectDb();
    $db->exec("SET FOREIGN_KEY_CHECKS=0");

    $db->exec("TRUNCATE sim_actypes");

    $json = file_get_contents(APPDIR."database/datafixtures/activities.json");
    $activities = json_decode($json, true);

    $stmt = $db->prepare(
        "INSERT INTO sim_activities
        VALUES (
            NULL,
            :name,
            :type,
            :affinity)"
    );
    $stmt->bindParam('name', $name);
    $stmt->bindParam('type', $type, PDO::PARAM_INT);
    $stmt->bindParam('affinity', $affinity);

    foreach($activities as $activity){
        extract($activity);

        $exe = $stmt->execute();

        if(!$exe){
            echo $stmt->errorInfo()[2];
            return false;
        }
    }
    $db->exec("SET FOREIGN_KEY_CHECKS=1");

    return true;
}
