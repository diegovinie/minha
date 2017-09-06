<?php
/*
 *
 */

function setDataBillsTable(/*int*/ $simId=1){

    if(!isset($_SESSION)) session_start();

    $_SESSION['sim_id'] = $simId;
    $_SESSION['prefix'] = 's1_';

    $handler = fopen(ROOTDIR.'/app/database/datafixtures/bills.csv', 'r');

    include_once ROOTDIR.'/models/functions.php';

    $data = convertCsvArray($handler);

    include_once ROOTDIR.'/components/bills/models/bills.php';

    foreach ($data as $index => $row) {
        extract($row);

        $jres = addBill(/*string*/ $desc, /*string*/ $date, /*int*/ $buiid,
                         /*int*/ $habid, /*int*/ $provid, /*int*/ $accid,
                         /*int*/ $actid, /*string*/ $log, /*float*/ $amount,
                         /*float*/ $iva, /*float*/ $total, null);

        $res = json_decode($jres);

        if($res->status != true){
            echo "\nError fila $index: $res->msg\n";
        }
    }
    echo "\ncambios completos\n";
    return true;
}
