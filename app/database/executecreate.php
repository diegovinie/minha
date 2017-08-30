<?php

include_once ROOTDIR.'/models/db.php';



if($param1 == 'database'){

    echo "Creando base de datos $param2:\n\n";

    createDatabase($param2);

}

$db = connectDb();

if($param1 == 'table'){
    include __DIR__."/create/create{$param2}table.php";

    $prefix = isset($param3)? $param3 : null;

    echo "Creando tabla $param2:\n\n";
    $res = call_user_func("create{$param2}table", $prefix);
}
else{
    echo "Operación exitosa.\n\n";
}
