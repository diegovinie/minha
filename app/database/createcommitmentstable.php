<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createCommitmentsTable(/*string*/ $prefix=null){
    $db = connectDb($prefix);
    $prx = $db->getPrx();

    $ex = $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS {$prx}commitments CASCADE;
        SET FOREIGN_KEY_CHECKS=1;"
    );

    $exe = $db->exec(
        "CREATE TABLE {$prx}commitments (
          `com_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `com_prov_fk` int(8) unsigned NOT NULL COMMENT 'Enlace al proveedor',
          `com_user_fk` int(8) unsigned NOT NULL COMMENT 'Enlace al usuario contratante',
          `com_bui` varchar(30) NOT NULL COMMENT 'El edificio del contratante',
          `com_name` varchar(64) NOT NULL
          `com_ini` DATE NOT NULL COMMENT 'Fecha de inicio',
          `com_end` DATE NULL NOT NULL COMMENT 'Fecha de culminacion',
          `com_notes` varchar(512) NULL NOT NULL COMMENT 'De preferencia en json',
          
          PRIMARY KEY (`com_id`),
          KEY `com_prov_fk` (`com_prov_fk`),
          KEY `com_user_fk` (`com_user_fk`),
          CONSTRAINT `{$prx}link_com_prov` FOREIGN KEY (`com_prov_fk`) REFERENCES `{$prx}providers` (`prov_id`),
          CONSTRAINT `{$prx}link_com_user` FOREIGN KEY (`com_user_fk`) REFERENCES `{$prx}users` (`user_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Contratos'"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
