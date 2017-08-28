<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createProvidersTable(/*string*/ $prefix=null){
    $db = connectDb($prefix);
    $prx = $db->getPrx();

    $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS {$prx}providers;
        SET FOREIGN_KEY_CHECKS=1;"
    );

    $exe = $db->exec(
        "CREATE TABLE {$prx}providers (
          `prov_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `prov_name` varchar(64) NOT NULL,
          `prov_alias` varchar(24) NOT NULL COMMENT 'nombre corto',
          `prov_rif` varchar(11) DEFAULT NULL COMMENT 'cedula o rif',
          `prov_cel` varchar(13) DEFAULT NULL,
          `prov_email` varchar(64) DEFAULT NULL,

          PRIMARY KEY (`prov_id`)
        ) ENGINE=InnoDB COLLATE=utf8_spanish_ci DEFAULT CHARSET=utf8"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
