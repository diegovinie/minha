<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createUserdataTable(/*string*/ $prefix=null){
    $db = connectDb($prefix);
    $prx = $db->getPrx();

    $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS {$prx}userdata;
        SET FOREIGN_KEY_CHECKS=1;"
    );

    $exe = $db->exec(
        "CREATE TABLE {$prx}userdata (
          `udata_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `udata_name` varchar(50) NOT NULL,
          `udata_surname` varchar(50) NOT NULL,
          `udata_ci` varchar(10) DEFAULT NULL COMMENT 'cedula o rif',
          `udata_cel` varchar(13) DEFAULT NULL,
          `udata_cond` int(1) NOT NULL DEFAULT '1',
          `udata_gender` varchar(1) DEFAULT NULL COMMENT 'M o F',
          `udata_nac` DATE NOT NULL COMMENT 'Fecha de nacimiento',
          `udata_bui_fk` int(8) unsigned NOT NULL COMMENT 'numero de apartamento',
          `udata_user_fk` int(8) unsigned NOT NULL,

          PRIMARY KEY (`udata_id`),
          KEY `{$prx}udata_user` (`udata_user_fk`),
          KEY `{$prx}udata_bui` (`udata_bui_fk`),
          CONSTRAINT `{$prx}link_udata_user` FOREIGN KEY (`udata_user_fk`) REFERENCES `{$prx}users` (`user_id`),
          CONSTRAINT `{$prx}link_udata_bui` FOREIGN KEY (`udata_bui_fk`) REFERENCES `{$prx}buildings` (`bui_id`)
        ) ENGINE=InnoDB COLLATE=utf8_spanish_ci DEFAULT CHARSET=utf8"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
