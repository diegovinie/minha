<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createCookiesTable(){
    $db = connectDb();

    $ex = $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS glo_cookies CASCADE;
        SET FOREIGN_KEY_CHECKS=1;"
    );

    $exe = $db->exec(
        "CREATE TABLE glo_cookies (
          `coo_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `coo_key` varchar(20) NOT NULL,
          `coo_val` varchar(64) NOT NULL DEFAULT '',
          `coo_info` varchar(512) NOT NULL,
          `coo_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,

          PRIMARY KEY (`coo_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
