<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createActivitiesTable(){
    $db = connectDb();

    $exe = $db->exec(
        "CREATE TABLE IF NOT EXISTS sim_activities (
          `act_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `act_name` varchar(32) NOT NULL,
          `act_aty_fk` int(8) unsigned NOT NULL COMMENT 'Tipo de actividad',
          `act_affinity` int(2) unsigned DEFAULT NULL COMMENT 'Afinidad entre actividades',

          PRIMARY KEY (`act_id`),
          KEY `act_aty_fk` (`act_aty_fk`),
          CONSTRAINT `sim_link_act_aty` FOREIGN KEY (`act_aty_fk`) REFERENCES `sim_actypes` (`aty_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Actividades de los Proveedores'"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
