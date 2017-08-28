<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createBuildingsTable(){
    $db = connectDb();

    $ex = $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS glo_buildings CASCADE;
        SET FOREIGN_KEY_CHECKS=1;"
    );

    $exe = $db->exec(
        "CREATE TABLE glo_buildings (
          `bui_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `bui_name` varchar(64) NOT NULL,
          `bui_edf` varchar(30) NOT NULL COMMENT 'Nombre corto',
          `bui_num` int(4) NOT NULL COMMENT 'Numero de apartamentos',
          `bui_levels` int(4) NOT NULL COMMENT 'Numero de pisos',
          `bui_parking` int(4) NOT NULL,
          `bui_cons` int(1) NOT NULL COMMENT 'Si tiene conserjeria',
          `bui_ofi` int(4) NOT NULL  COMMENT 'Si tiene oficinas',
          `bui_gardens` int(4) NOT NULL COMMENT 'm2 de jardines',
          `bui_notes` varchar(512) DEFAULT NULL,

          PRIMARY KEY (`bui_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
