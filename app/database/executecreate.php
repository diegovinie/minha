<?php

include_once ROOTDIR.'/models/db.php';

$db = connectDb();

$res = $stmt = $db->exec(
    "CREATE DATABASE $param1"
);

if(!$res){
    echo "Hubo un error en la operación:\n";
    echo $stmt->errorInfo()[2] ."\n";
}
else{
    echo "La base de datos $param1 fue creada.\n";
}
