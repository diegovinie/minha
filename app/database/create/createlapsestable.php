<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createLapsesTable(){
    $db = connectDb();

    $ex = $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS glo_lapses CASCADE;
        SET FOREIGN_KEY_CHECKS=1;"
    );

    $exe = $db->exec(
        "CREATE TABLE glo_lapses (
          `lap_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `lap_name` varchar(20) NOT NULL,
          `lap_month` int(2) NOT NULL,
          `lap_year` int(4) NOT NULL,

          PRIMARY KEY (`lap_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
