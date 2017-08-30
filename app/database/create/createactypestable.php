<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createActypesTable(){
    $db = connectDb();

    $exe = $db->exec(
        "CREATE TABLE IF NOT EXISTS sim_actypes (
          `aty_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `aty_name` varchar(32) NOT NULL,
          `aty_op` int(1) unsigned DEFAULT NULL COMMENT 'Opciones',

          PRIMARY KEY (`aty_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tipos de Actividades de los Proveedores'"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
