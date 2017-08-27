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
          `pay_bui_fk` int(8) unsigned NOT NULL COMMENT 'Id Apartamento',
          `pay_type` int(1) NOT NULL COMMENT 'Tipo de operacion',
          `pay_op` varchar(16) NOT NULL COMMENT 'Numero de operacion',
          `pay_bank_fk` int(8) unsigned NOT NULL COMMENT 'Banco',
          `pay_amount` decimal(10,2) NOT NULL COMMENT 'Monto del pago',
          `pay_check` int(1) DEFAULT NULL COMMENT 'Si ya fue relacionado',
          `pay_obs` varchar(256) DEFAULT NULL COMMENT 'Observaciones',
          `pay_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `pay_user_fk` int(8) unsigned NOT NULL,
          
          PRIMARY KEY (`pay_id`),
          KEY `index_pay` (`pay_user_fk`,`pay_type`,`pay_bank_fk`,`pay_bui_fk`),
          CONSTRAINT `{$prx}link_pay_bui` FOREIGN KEY (`pay_bui_fk`) REFERENCES `{$prx}buildings` (`bui_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
          CONSTRAINT `{$prx}link_pay_bank` FOREIGN KEY (`pay_bank_fk`) REFERENCES `glo_banks` (`bank_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE=InnoDB COLLATE=utf8_spanish_ci DEFAULT CHARSET=utf8"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
