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
    'users',
    'simulator',
    'buildings',
    'actypes',
    'activities'
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

$s1TablesNames = array(
    'apartments',
    'subjects',
    'providers',
    'skills',
    'funds',
    'habitants',
    'accounts',
    'bills',
    'charges',
    'payments',
    'commitments'
);

echo "\n\nCreando tablas globales:\n";

foreach ($globalTablesNames as $nameTable) {

  include_once(__DIR__."/create/create{$nameTable}table.php");

  echo "\n$nameTable       ";
  $res[] = call_user_func("create{$nameTable}Table", 'glo_');
}

echo "\n\nCreando tablas principales:\n";

foreach ($priTablesNames as $nameTable) {

  include_once(__DIR__."/create/create{$nameTable}table.php");

  echo "\n$nameTable       ";
  $res[] = call_user_func("create{$nameTable}Table", 'pri_');
}

echo "\n\nCreando tablas de simulador:\n";

foreach ($s1TablesNames as $nameTable) {

  include_once(__DIR__."/create/create{$nameTable}table.php");

  echo "\n$nameTable       ";
  $res[] = call_user_func("create{$nameTable}Table", 's1_');
}

echo "\n\nErrores:\n\n";

foreach ($res as $table => $status) {

    echo "$table: $status\n";
}

echo "\nOperación finalizada\n\n";
