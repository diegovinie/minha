<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function emptySingleTable($tableName, $prefix){
    $db = connectDb();
    $prx = $prefix? $prefix : $db->getPrx();

    $exe = $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        TRUNCATE {$prx}{$tableName};
        SET FOREIGN_KEY_CHECKS=1;"
    );

    if(!$exe){
        echo $db->errorInfo()[2];

    }
    return $exe;
}

function emptyGoupTable($groupName){

}

function emptyAllTable(){

}
