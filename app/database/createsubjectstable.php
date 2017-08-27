<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createSubjectsTable(/*string*/ $prefix=null){
    $db = connectDb($prefix);
    $prx = $db->getPrx();

    $ex = $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS {$prx}subjects CASCADE;
        SET FOREIGN_KEY_CHECKS=1;"
    );

    $exe = $db->exec(
        "CREATE TABLE {$prx}subjects (
          `sub_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `sub_type_fk` int(8) unsigned NOT NULL COMMENT 'En cual tabla reside',
          `sub_human` int(1) DEFAULT '0' COMMENT 'Es humano',
          `sub_active` int(1) DEFAULT '1',
          `sub_behavior` varchar(256) DEFAULT NULL COMMENT 'Comportamiento de preferencia json',

          PRIMARY KEY (`sub_id`),
          KEY `sub_type` (`sub_type_fk`),
          CONSTRAINT `{$prx}link_sub_type` FOREIGN KEY (`sub_type_fk`) REFERENCES `glo_types` (`type_id`)
        ) ENGINE=InnoDB COLLATE=utf8_spanish_ci DEFAULT CHARSET=utf8"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
