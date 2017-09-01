<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createHabitantsTable(/*string*/ $prefix=null){
    $db = connectDb($prefix);
    $prx = $db->getPrx();

    $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS {$prx}habitants;
        SET FOREIGN_KEY_CHECKS=1;"
    );

    $exe = $db->exec(
        "CREATE TABLE {$prx}habitants (
          `hab_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `hab_name` varchar(50) NOT NULL,
          `hab_surname` varchar(50) NOT NULL,
          `hab_ci` varchar(10) DEFAULT NULL COMMENT 'cedula o rif',
          `hab_cel` varchar(13) DEFAULT NULL,
          `hab_cond` int(1) NOT NULL DEFAULT '1' COMMENT 'Titular o Familiar',
          `hab_role` int(1) NOT NULL DEFAULT '1' COMMENT 'Usuario o Administrador',
          `hab_accepted` int(1) NOT NULL DEFAULT '1' COMMENT 'Si ya fue aceptado',
          `hab_gender` varchar(1) DEFAULT NULL COMMENT 'M o F',
          `hab_nac` DATE DEFAULT NULL COMMENT 'Fecha de nacimiento',
          `hab_email` varchar(64) DEFAULT NULL COMMENT 'Correo electronico',
          `hab_apt_fk` int(8) unsigned NOT NULL COMMENT 'numero de apartamento',
          `hab_user_fk` int(8) unsigned NOT NULL,

          PRIMARY KEY (`hab_id`),
          KEY `{$prx}hab_user` (`hab_user_fk`),
          KEY `{$prx}hab_apt` (`hab_apt_fk`),
          CONSTRAINT `{$prx}link_hab_user` FOREIGN KEY (`hab_user_fk`) REFERENCES `glo_users` (`user_id`),
          CONSTRAINT `{$prx}link_hab_apt` FOREIGN KEY (`hab_apt_fk`) REFERENCES `{$prx}apartments` (`apt_id`)
        ) ENGINE=InnoDB COLLATE=utf8_spanish_ci DEFAULT CHARSET=utf8"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
