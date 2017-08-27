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
          `acc_name` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
          `acc_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
          `acc_type` int(1) unsigned NOT NULL COMMENT 'Cuenta principal, caja chica',
          `acc_user_fk` int(8) unsigned NOT NULL COMMENT 'Responsable de la cuenta',
          `acc_max` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Aplica si es caja chica',
          `acc_bui` varchar(30) CHARACTER SET utf8 NOT NULL,
          `acc_creator` varchar(30) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'sysadmin' COMMENT 'El creador de la cuenta',
          `acc_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          
          PRIMARY KEY (`acc_id`),
          KEY `acc_user_fk` (`acc_user_fk`),
          KEY `acc_name` (`acc_name`),
          CONSTRAINT `{$prx}link_acc_user` FOREIGN KEY (`acc_user_fk`) REFERENCES `{$prx}users` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Cuentas y cajas chicas en uso'"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
