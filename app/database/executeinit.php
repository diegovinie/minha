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

echo "\nCreando tablas:\n\n";

foreach ($globalTablesNames as $name) {
    include_once(__DIR__."/create{$name}table.php");

    echo "$name       ";
    $results[$name] = call_user_func("create{$name}Table");
    echo "\n";
}

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

foreach ($priTablesNames as $name) {
    include_once(__DIR__."/create{$name}table.php");

    echo "$name       ";
    $results[$name] = call_user_func("create{$name}Table", 'pri_');
    echo "\n";
}

echo "\n\nErrores:\n\n";

foreach ($results as $table => $status) {

    echo "$table: $status\n";
}

echo "\nOperación finalizada\n\n";
