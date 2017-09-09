<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createLapsesTable(/*string*/ $prefix=null){
    $db = connectDb($prefix);
    $prx = $db->getPrx();

    $ex = $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS {$prx}lapses CASCADE;
        SET FOREIGN_KEY_CHECKS=1;"
    );

    $exe = $db->exec(
        "CREATE TABLE {$prx}lapses (
          `lap_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `lap_name` varchar(20) NOT NULL,
          `lap_month` int(2) NOT NULL,
          `lap_year` int(4) NOT NULL,
          `lap_exec` boolean NOT NULL DEFAULT FALSE COMMENT 'Si ya fue calculado el periodo',
          `lap_sim_fk` int(8) unsigned NOT NULL,

          PRIMARY KEY (`lap_id`),
          KEY `lap_sim_fk` (`lap_sim_fk`),
          CONSTRAINT {$prx}link_lap_sim FOREIGN KEY (`lap_sim_fk`) REFERENCES glo_simulator (`sim_id`) ON DELETE CASCADE ON UPDATE CASCADE 
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
