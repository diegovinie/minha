<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createTypesTable(){
    $db = connectDb();

    $ex = $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS glo_types CASCADE;
        SET FOREIGN_KEY_CHECKS=1;"
    );

    $exe = $db->exec(
        "CREATE TABLE glo_types (
          `type_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `type_name` varchar(24) NOT NULL,
          
          PRIMARY KEY (`sub_id`)
        ) ENGINE=InnoDB COLLATE=utf8_spanish_ci DEFAULT CHARSET=utf8"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
