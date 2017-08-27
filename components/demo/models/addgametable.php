<?php
/* Pendiente para borrar */

include_once ROOTDIR.'/models/db.php';

function addGameTable($user){
    $db = connectDb();

    $stmt = $db->prepare(
        "INSERT INTO glo_game
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
