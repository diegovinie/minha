<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createApartmentsTable(/*string*/ $prefix=null){
    $db = connectDb($prefix);
    $prx = $db->getPrx();

    $ex = $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS {$prx}apartments CASCADE;
        SET FOREIGN_KEY_CHECKS=1;"
    );
    //if(!$ex) print_r($db->errorInfo()); die;
    $exe = $db->exec(
        "CREATE TABLE {$prx}apartments (
          `apt_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `apt_name` varchar(10) NOT NULL COMMENT 'Nombre del apartamento',
          `apt_bui_fk` int(8) unsigned NOT NULL COMMENT 'id del edificio',
          `apt_edf` varchar(30) NOT NULL COMMENT 'Nombre del edificio',
          `apt_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
          `apt_weight` varchar(10) NOT NULL DEFAULT '0.00' COMMENT 'Porcentaje ponderado',
          `apt_assigned` tinyint(1) NOT NULL DEFAULT '1',
          `apt_occupied` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Si esta habitado',
          `apt_notes` varchar(1024) DEFAULT NULL,
          `apt_sim_fk` int(8) unsigned NOT NULL,

          PRIMARY KEY (`apt_id`),
          KEY `apt_bui_fk` (`apt_bui_fk`),
          KEY `apt_sim_fk` (`apt_sim_fk`),
          CONSTRAINT `{$prx}link_apt_sim` FOREIGN KEY (`apt_sim_fk`) REFERENCES `glo_simulator` (`sim_id`)  ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `{$prx}link_apt_bui` FOREIGN KEY (`apt_bui_fk`) REFERENCES `glo_buildings` (`bui_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE=InnoDB COLLATE=utf8_spanish_ci DEFAULT CHARSET=utf8"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
