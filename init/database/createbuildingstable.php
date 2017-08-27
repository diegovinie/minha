<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createBuildingsTable(/*string*/ $prefix=null){
    $db = connectDb($prefix);
    $prx = $db->getPrx();

    $ex = $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS {$prx}buildings CASCADE;
        SET FOREIGN_KEY_CHECKS=1;"
    );
    //if(!$ex) print_r($db->errorInfo()); die;
    $exe = $db->exec(
        "CREATE TABLE {$prx}buildings (
          `bui_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `bui_name` varchar(30) NOT NULL DEFAULT 'A17',
          `bui_apt` varchar(3) NOT NULL,
          `bui_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
          `bui_weight` varchar(10) NOT NULL DEFAULT '0.00' COMMENT 'Porcentaje ponderado',
          `bui_assigned` tinyint(1) NOT NULL DEFAULT '1',
          `bui_occupied` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Si esta habitado',
          `bui_notes` varchar(1000) DEFAULT NULL,
          PRIMARY KEY (`bui_id`),
          UNIQUE KEY `bui_number_2` (`bui_apt`),
          KEY `bui_number` (`bui_apt`)
        ) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
