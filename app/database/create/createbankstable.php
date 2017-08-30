<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createBanksTable(){
    $db = connectDb();

    $ex = $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS glo_banks CASCADE;
        SET FOREIGN_KEY_CHECKS=1;"
    );

    $exe = $db->exec(
        "CREATE TABLE glo_banks (
          `bank_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `bank_name` varchar(64) NOT NULL,
          `bank_rif` varchar(10) DEFAULT NULL,
          `bank_op` int(1) DEFAULT NULL COMMENT 'Indicador para uso futuro',
          `bank_prx` CHAR(4) DEFAULT NULL,
          
          PRIMARY KEY (`bank_id`)
        ) ENGINE=InnoDB COLLATE=utf8_spanish_ci DEFAULT CHARSET=utf8"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
