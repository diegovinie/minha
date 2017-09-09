<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createPaymentsTable(/*string*/ $prefix=null){
    $db = connectDb($prefix);
    $prx = $db->getPrx();

    $ex = $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS {$prx}payments CASCADE;
        SET FOREIGN_KEY_CHECKS=1;"
    );

    $exe = $db->exec(
        "CREATE TABLE {$prx}payments (
          `pay_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `pay_date` date NOT NULL COMMENT 'Fecha de la operacion',
          `pay_edf` varchar(30) NOT NULL COMMENT 'Nombre del edificio',
          `pay_apt_fk` int(8) unsigned NOT NULL COMMENT 'Enlace a apartamentos',
          `pay_hab_fk` int(8) unsigned NOT NULL COMMENT 'Enlace a habitantes',
          `pay_type` int(1) NOT NULL COMMENT 'Tipo de operacion',
          `pay_op` varchar(16) NOT NULL COMMENT 'Numero de operacion',
          `pay_bank_fk` int(8) unsigned NOT NULL COMMENT 'Enlace a bancos',
          `pay_amount` decimal(10,2) NOT NULL COMMENT 'Monto del pago',
          `pay_check` int(1) DEFAULT NULL COMMENT 'Si ya fue relacionado',
          `pay_obs` varchar(256) DEFAULT NULL COMMENT 'Observaciones',
          `pay_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

          PRIMARY KEY (`pay_id`),
          KEY `pay_apt_fk` (`pay_apt_fk`),
          KEY `pay_hab_fk` (`pay_hab_fk`),
          KEY `pay_bank_fk` (`pay_bank_fk`),
          CONSTRAINT `{$prx}link_pay_apt` FOREIGN KEY (`pay_apt_fk`) REFERENCES `{$prx}apartments` (`apt_id`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `{$prx}link_pay_bank` FOREIGN KEY (`pay_bank_fk`) REFERENCES `glo_banks` (`bank_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
          CONSTRAINT `{$prx}link_pay_hab` FOREIGN KEY (`pay_hab_fk`) REFERENCES `{$prx}habitants` (`hab_id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB COLLATE=utf8_spanish_ci DEFAULT CHARSET=utf8"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
