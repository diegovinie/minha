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
        DROP TABLE IF EXISTS {$prx}movements CASCADE;
        SET FOREIGN_KEY_CHECKS=1;"
    );

    $exe = $db->exec(
        "CREATE TABLE {$prx}movements (
          `mov_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `mov_origin_acc_fk` int(8) unsigned NOT NULL,
          `mov_destiny_acc_fk` int(8) unsigned NOT NULL,
          `mov_hab_fk`  int(8) unsigned NOT NULL,
          `mov_amount` DECIMAL(10,2) NOT NULL,
          `mov_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,

          PRIMARY KEY (`mov_id`),
          KEY `mov_hab_fk` (`mov_hab_fk`),
          KEY `acc_bui_fk` (`acc_bui_fk`),
          KEY `acc_sim_fk` (`acc_sim_fk`),
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
