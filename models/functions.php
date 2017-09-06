<?php


function convertCsvArray(/*resource*/ $handle){

    $keys = fgetcsv($handle);
    $data = array();

    while(!feof($handle)){
        $values = fgetcsv($handle);
        $i = 0;
        $row = array();
        if(!$values) break;

        for($i = 0; $i < count($keys); $i++){

            $row[$keys[$i]] = $values[$i];
        }
        $data[] = $row;
    }

    return $data;
}
