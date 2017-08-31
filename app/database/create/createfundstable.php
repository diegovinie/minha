<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createFundsTable(/*string*/ $prefix=null){
    $db = connectDb($prefix);
    $prx = $db->getPrx();

    $ex = $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS {$prx}funds CASCADE;
        SET FOREIGN_KEY_CHECKS=1;"
    );

    $exe = $db->exec(
        "CREATE TABLE {$prx}funds (
          `fun_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `fun_name` varchar(100) NOT NULL,
          `fun_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
          `fun_default` varchar(20) NOT NULL DEFAULT '0' COMMENT 'Monto a cobrar mensualmente',
          `fun_type` int(1) NOT NULL DEFAULT '1' COMMENT 'Fondo de trabajo, cuota especial',
          `fun_bui_fk` int(8) unsigned NOT NULL COMMENT 'Enlace a buildings',
          `fun_creator` varchar(30) NOT NULL DEFAULT 'sysadmin',
          `fun_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,

          PRIMARY KEY (`fun_id`),
          KEY `fun_bui_fk` (fun_bui_fk),
          CONSTRAINT `{$prx}link_fun_bui` FOREIGN KEY (`fun_bui_fk`) REFERENCES `glo_buildings` (`bui_id`)
        ) ENGINE=InnoDB COLLATE=utf8_spanish_ci DEFAULT CHARSET=utf8 COMMENT='Fondos y Cuotas especiales'"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
