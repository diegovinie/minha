<?php

include_once ROOTDIR.'/models/db.php';

$db = connectDb();

if($param1 == 'database'){

  echo "Creando base de datos $param2:\n\n";

  $res = $db->exec(
      "CREATE DATABASE $param2"
  );
  
  if(!$res){
      echo "Hubo un error en la operación:\n";
      echo $db->errorInfo()[2] ."\n\n";
  }
}

if($param1 == 'table'){
    include APPDIR."database/create{$param2}table.php";

    $prefix = isset($param3)? $param3 : null;

    echo "Creando tabla $param2:\n\n";
    $res = call_user_func("create{$param2}table", $prefix);
}


else{
    echo "Operación exitosa.\n\n";
}
