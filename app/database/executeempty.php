<?php

echo "\n";
include __DIR__."/emptytable.php";

switch ($param1) {

    case 'single':
        $prefix = isset($param3)? $param3.'_' : null;

        echo "Truncando tabla $param2\n\n";

        call_user_func("emptysingletable", $tableName, $prefix);
        break;

    case 'user':

        $tables = array(
            'apartments',
            'subjects',
            'providers',
            'funds',
            'habitants',
            'accounts',
            'bills',
            'charges',
            'payments',
            'commitments'
        );
        $prefix = isset($param2)? $param2.'_' : null;

        foreach ($tables as $tableName) {

            echo "Truncando tabla $tableName\n\n";

            call_user_func("emptysingletable", $tableName, $prefix);
        }
        break;

    case 'globals':

    $globalTablesNames = array(
        'types',
        'lapses',
        'banks',
        'cookies',
        'simulator',
        'buildings',
        'users'
    );

        foreach ($globalTablesNames as $tableName) {

            echo "Truncando tabla $tableName\n\n";

            call_user_func("emptysingletable", $tableName, 'glo_');
        }
        break;

    default:
        # code...
        break;
}
