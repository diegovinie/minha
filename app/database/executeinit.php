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


echo "\nCreando tablas:\n\n";

foreach ($globalTablesNames as $nameTable) {

  include_once(__DIR__."/create/create{$nameTable}table.php");

  echo "\n$nameTable       ";
  $res[] = call_user_func("create{$nameTable}Table", 'glo_');
}


foreach ($priTablesNames as $nameTable) {

  include_once(__DIR__."/create/create{$nameTable}table.php");

  echo "\n$nameTable       ";
  $res[] = call_user_func("create{$nameTable}Table", 'pri_');
}

echo "\n\nErrores:\n\n";

foreach ($res as $table => $status) {

    echo "$table: $status\n";
}

echo "\nOperación finalizada\n\n";
