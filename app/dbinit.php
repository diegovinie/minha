<?php
/*
 *
 */
echo "si";die;
include_once ROOTDIR.'/models/db.php';

$globalTablesNames = array(
    'lapses',
    'banks',
    'cookies',
    'game'
);

foreach ($globalTablesNames as $name) {
    include_once(ROOTDIR."/init/database/create{$name}table.php");

    echo "$name : ";
    $results[$name] = call_user_func("create{$name}Table");
    echo "\n";
}

$priTablesNames = array(
    'buildings',
    'subjects',
    'users',
    'providers',
    'funds',
    'accounts',
    'bills',
    'charges',
    'payments',
    'commitments'
);

foreach ($priTablesNames as $name) {
    include_once(ROOTDIR."/init/database/create{$name}table.php");

    echo "$name : ";
    $results[$name] = call_user_func("create{$name}Table", 'pri_');
    echo "\n";
}

foreach ($results as $table => $status) {

    echo "$table: $status\n";
}
