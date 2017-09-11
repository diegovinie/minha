<?php

include_once ROOTDIR.'/models/db.php';

function getTitularHabitant(/*int*/ $aptid){
    $db = connectDB();
    $prx = $db->getPrx();
    $status = false;

    $stmt = $db->prepare(
        "SELECT hab_name AS 'name',
            hab_surname AS 'surname',
            hab_ci AS 'ci',
            apt_name AS 'apt',
            apt_edf AS 'edf'
        FROM {$prx}habitants
            INNER JOIN {$prx}apartments ON hab_apt_fk = apt_id
        WHERE apt_id = :aptid
            AND hab_cond = 1
        ORDER BY hab_ci
        LIMIT 1"
    );
    $stmt->bindValue('aptid', $aptid, PDO::PARAM_INT);

    $res = $stmt->execute();

    if(!$res){
        echo "Error al recuperar datos.".$stmt->errorInfo()[2];
        return false;
    }
    else{
        $msg = $stmt->fetch(PDO::FETCH_ASSOC);
        return $msg;
    }
}

function getBatch(/*string*/ $edf, /*int*/ $number){
    $db = connectDB();
    $prx = $db->getPrx();

    $batchFile = ROOTDIR."/files/{$prx}invoices/{$edf}/LOT-{$number}.json";

    if(!is_file($batchFile)) return false;

    $json = file_get_contents($batchFile);

    $batchArray = json_decode($json, true);

    return $batchArray;
}

function getAptContentInvoice(/*int*/ $aptid, /*int*/ $number){

    $titularData = getTitularHabitant($aptid);
    if(!$titularData) return false;

    $edf = $titularData['edf'];
    $apt = $titularData['apt'];

    $batch = getBatch($edf, $number);

    if(!$batch) return false;

    $contentArray = $batch['content'][$apt];

    return $contentArray;
}

function getInvoiceHeader(/*int*/ $aptid, /*int*/ $number){

    $titularData = getTitularHabitant($aptid);
    if(!$titularData) return false;

    $edf = $titularData['edf'];
    $apt = $titularData['apt'];

    $batch = getBatch($edf, $number);
    if(!$batch) return false;

    $data = $batch['head'];
    $data['monto'] = $batch['charges'][$apt]['actual'];
    $data['titular'] = $titularData;

    return $data;
}

function getAptFootInvoice(/*int*/ $aptid, /*int*/ $number){

    $titularData = getTitularHabitant($aptid);
    if(!$titularData) return false;

    $edf = $titularData['edf'];
    $apt = $titularData['apt'];

    $batch = getBatch($edf, $number);
    if(!$batch) return false;

    return $batch['charges'][$apt];
}
