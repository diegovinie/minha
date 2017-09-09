<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createFirmsTable(/*string*/ $prefix=null){
    $db = connectDb($prefix);
    $prx = $db->getPrx();

    $ex = $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS {$prx}firms CASCADE;
        SET FOREIGN_KEY_CHECKS=1;"
    );

    $exe = $db->exec(
        "CREATE TABLE {$prx}firms (
          `fir_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `fir_tag` CHAR(1) NOT NULL DEFAULT 'X' COMMENT 'Tipo de firma',
          `fir_formula` varchar(10) DEFAULT NULL COMMENT 'Fórmula de firmas',
          `fir_hab_fk` int(8) unsigned NOT NULL COMMENT 'Enlace a habitantes',
          `fir_acc_fk` int(8) unsigned NOT NULL COMMENT 'Enlace a cuentas',
          `fir_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

          PRIMARY KEY (`fir_id`),
          KEY `fir_hab_fk` (`fir_hab_fk`),
          KEY `fir_acc_fk` (`fir_acc_fk`),
          CONSTRAINT `{$prx}link_fir_acc` FOREIGN KEY (`fir_acc_fk`) REFERENCES `{$prx}accounts` (`acc_id`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `{$prx}link_fir_hab` FOREIGN KEY (`fir_hab_fk`) REFERENCES `{$prx}habitants` (`hab_id`) ON DELETE CASCADE ON UPDATE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Firmas usuarios y cuentas'"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
