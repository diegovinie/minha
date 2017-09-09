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
          `type_ref` int(8) unsigned DEFAULT NULL COMMENT 'Referencia interna',
          `type_op` int(1) unsigned DEFAULT 0,

          PRIMARY KEY (`type_id`),
          KEY `type_ref` (`type_ref`),
          CONSTRAINT `glo_link_type_self` FOREIGN KEY (`type_ref`) REFERENCES `glo_types` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB COLLATE=utf8_spanish_ci DEFAULT CHARSET=utf8"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
