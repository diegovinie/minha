<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createSimulatorTable(){
    $db = connectDb();

    $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS glo_simulator;
        SET FOREIGN_KEY_CHECKS=1;"
    );

    $exe = $db->exec(
        "CREATE TABLE glo_simulator (
            sim_id int(8) unsigned NOT NULL AUTO_INCREMENT,
            sim_user VARCHAR(64) NOT NULL,
            sim_ts TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            sim_exp TIMESTAMP AS (sim_ts + INTERVAL 7 DAY) VIRTUAL,
            sim_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            sim_score int(8) NULL DEFAULT NULL,

            PRIMARY KEY (`sim_id`))
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
