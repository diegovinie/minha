<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createAccountsTable(/*string*/ $prefix=null){
    $db = connectDb($prefix);
    $prx = $db->getPrx();

    $ex = $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS {$prx}accounts CASCADE;
        SET FOREIGN_KEY_CHECKS=1;"
    );

    $exe = $db->exec(
        "CREATE TABLE {$prx}accounts (
          `acc_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `acc_name` varchar(200) NOT NULL,
          `acc_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
          `acc_default` decimal(10,2) DEFAULT NULL COMMENT 'Aplica si es caja chica',
          `acc_type_fk` int(8) unsigned DEFAULT NULL COMMENT 'Cuenta principal, caja chica',
          `acc_op` int(1) unsigned DEFAULT NULL COMMENT 'Opciones especiales',
          `acc_hab_fk` int(8) unsigned NOT NULL COMMENT 'Responsable de la cuenta',
          `acc_bui_fk` int(8) unsigned DEFAULT NULL,
          `acc_sim_fk` int(8) unsigned NOT NULL,
          `acc_creator` varchar(30) NOT NULL DEFAULT 'sysadmin' COMMENT 'El creador de la cuenta',
          `acc_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

          PRIMARY KEY (`acc_id`),
          KEY `acc_type_fk` (`acc_type_fk`),
          KEY `acc_hab_fk` (`acc_hab_fk`),
          KEY `acc_bui_fk` (`acc_bui_fk`),
          KEY `acc_sim_fk` (`acc_sim_fk`),
          CONSTRAINT `{$prx}link_acc_type` FOREIGN KEY (`acc_type_fk`) REFERENCES `glo_types` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `{$prx}link_acc_sim` FOREIGN KEY (`acc_sim_fk`) REFERENCES `glo_simulator` (`sim_id`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `{$prx}link_acc_hab` FOREIGN KEY (`acc_hab_fk`) REFERENCES `{$prx}habitants` (`hab_id`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `{$prx}link_acc_bui` FOREIGN KEY (`acc_bui_fk`) REFERENCES `glo_buildings` (`bui_id`) ON DELETE SET NULL ON UPDATE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Cuentas y cajas chicas en uso'"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
