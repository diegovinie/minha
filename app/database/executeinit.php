<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

$globalTablesNames = array(
    'types',
    'lapses',
    'banks',
    'cookies',
    'simulator',
    'buildings',
    'users'
);

$priTablesNames = array(
    'apartments',
    'subjects',
    'habitants',
    'providers',
    'funds',
    'accounts',
    'bills',
    'charges',
    'payments',
    'commitments'
);

function createSingleTable(/*string*/ $name, /*string*/  $prefix=null){

        include_once(__DIR__."/create/create{$name}table.php");

        echo "\n$name       ";
        return call_user_func("create{$name}Table", $prefix);

}

echo "\nCreando tablas:\n\n";

$res[] = array_map('createSingleTable', $globalTablesNames);

$res[] = array_map('createSingleTable', $priTablesNames, 'pri_');


echo "\n\nErrores:\n\n";

foreach ($results as $table => $status) {

    echo "$table: $status\n";
}

echo "\nOperación finalizada\n\n";
