<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createGameTable(){
    $db = connectDb();

    $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS pri_game;
        SET FOREIGN_KEY_CHECKS=1;"
    );

    $exe = $db->exec(
        "CREATE TABLE pri_game (
            gam_id int(8) unsigned NOT NULL AUTO_INCREMENT,
            gam_user VARCHAR(64) NOT NULL,
            gam_ts TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            gam_exp TIMESTAMP AS (gam_ts + INTERVAL 7 DAY) VIRTUAL,
            gam_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            gam_score int(8) NULL DEFAULT NULL,
            PRIMARY KEY (`gam_id`))
        ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
        return false;
    }
    else{
        return true;
    }
}
