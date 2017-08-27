<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createUsersTable(/*string*/ $prefix=null){
    $db = connectDb($prefix);
    $prx = $db->getPrx();

    $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS {$prx}users;
        SET FOREIGN_KEY_CHECKS=1;"
    );

    $exe = $db->exec(
        "CREATE TABLE {$prx}users (
          `user_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `user_user` varchar(64) NOT NULL COMMENT 'e-mail como usuario',
          `user_pwd` varchar(64) NOT NULL,
          `user_question` varchar(64) DEFAULT NULL,
          `user_response` varchar(64) DEFAULT NULL,
          `user_type` int(1) NOT NULL COMMENT 'tipo de usuario',
          `user_active` int(1) DEFAULT NULL,
          `user_creator` varchar(64) DEFAULT NULL,
          `user_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`user_id`),
          KEY `user_user` (`user_user`),
          KEY `user_type` (`user_type`),
          KEY `user_id` (`user_id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=249 DEFAULT CHARSET=utf8 COMMENT='Tabla de usuarios para el acceso'"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
