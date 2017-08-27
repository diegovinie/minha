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
          `bui_name` varchar(30) NOT NULL COMMENT 'Nombre del edificio',
          `bui_apt` varchar(10) NOT NULL COMMENT 'Nombre del apartamento',
          `bui_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
          `bui_weight` varchar(10) NOT NULL DEFAULT '0.00' COMMENT 'Porcentaje ponderado',
          `bui_assigned` tinyint(1) NOT NULL DEFAULT '1',
          `bui_occupied` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Si esta habitado',
          `bui_notes` varchar(1024) DEFAULT NULL,
          
          PRIMARY KEY (`bui_id`)
        ) ENGINE=InnoDB COLLATE=utf8_spanish_ci DEFAULT CHARSET=utf8"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
