<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createSkillsTable(/*string*/ $prefix=null){
    $db = connectDb($prefix);
    $prx = $db->getPrx();

    $ex = $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS {$prx}skills CASCADE;
        SET FOREIGN_KEY_CHECKS=1;"
    );
    
    $exe = $db->exec(
        "CREATE TABLE {$prx}skills (
          `ski_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `ski_prov_fk` int(8) unsigned NOT NULL COMMENT 'Enlace con proveedores',
          `ski_act_fk` int(8) unsigned NOT NULL COMMENT 'Enlace con actividades',
          `ski_quality` int(2) unsigned NOT NULL COMMENT 'Calidad del trabajo',
          `ski_cost` decimal(10,2) NOT NULL  COMMENT 'Costo del trabajo',

          PRIMARY KEY (`ski_id`),
          KEY `ski_prov_fk` (`ski_prov_fk`),
          KEY `ski_act_fk` (`ski_act_fk`),
          CONSTRAINT `{$prx}link_ski_prov` FOREIGN KEY (`ski_prov_fk`) REFERENCES `{$prx}providers` (`prov_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
          CONSTRAINT `{$prx}link_ski_act` FOREIGN KEY (`ski_act_fk`) REFERENCES `sim_activities` (`act_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE=InnoDB COLLATE=utf8_spanish_ci DEFAULT CHARSET=utf8"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
