<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createChargesTable(/*string*/ $prefix=null){
    $db = connectDb($prefix);
    $prx = $db->getPrx();

    $ex = $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS {$prx}charges CASCADE;
        SET FOREIGN_KEY_CHECKS=1;"
    );

    $exe = $db->exec(
        "CREATE TABLE {$prx}charges (
          `cha_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `cha_bui_fk` int(8) unsigned NOT NULL COMMENT 'Apartamento',
          `cha_lap_fk` int(8) unsigned NOT NULL COMMENT 'Periodo de cobro',
          `cha_amount` decimal(10,2) NOT NULL COMMENT 'Cantidad a cobrar',
          `cha_total` decimal(10,2) NOT NULL COMMENT 'Cantidad total del edificio',
          `cha_email` int(1) unsigned NOT NULL COMMENT 'Si fue enviado',
          `cha_print` int(1) unsigned NOT NULL COMMENT 'Si fue impreso',
          `cha_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `cha_user` varchar(64) CHARACTER SET utf32 COLLATE utf32_spanish_ci NOT NULL COMMENT 'email del creador',

          PRIMARY KEY (`cha_id`),
          KEY `cha_bui_fk` (`cha_bui_fk`),
          KEY `cha_lap_fk` (`cha_lap_fk`),
          CONSTRAINT `{$prx}link_cha_bui` FOREIGN KEY (`cha_bui_fk`) REFERENCES `{$prx}buildings` (`bui_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
          CONSTRAINT `{$prx}link_cha_lap` FOREIGN KEY (`cha_lap_fk`) REFERENCES `glo_lapses` (`lap_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE=InnoDB COLLATE=utf8_spanish_ci DEFAULT CHARSET=utf8 COMMENT='Se lleva el balance de cobros'"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
