<?php
/* Pendiente para borrar */

include_once ROOTDIR.'/models/db.php';

function addGetSimulatorTable($user){
    $db = connectDb();

    $stmt = $db->prepare(
        "INSERT INTO glo_simulator
        (sim_id, sim_user, sim_ts)
        VALUES (NULL, :user, NULL)"
    );
    $stmt->bindValue('user', $user);
    $res = $stmt->execute();

    if(!$res){
        echo $db->errorInfo()[2];
        return false;
    }

    $res2 = $db->query(
        "SELECT sim_id
        FROM glo_simulator
        ORDER BY sim_id DESC
        LIMIT 1"
    );

    if(!$res2){
        echo $db->errorInfo()[2];
        return false;
    }

    return $res2->fetchColumn();
}
