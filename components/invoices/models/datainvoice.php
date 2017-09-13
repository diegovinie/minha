<?php

include_once ROOTDIR.'/models/db.php';
include_once $basedir.'models/invoicepdf.php';

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
    $simid = $db->getSimId();

    $batchFile = ROOTDIR."/files/{$prx}invoices/{$edf}/LOT_$simid-{$number}.json";

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

function makePdf(/*array*/ $header, /*array*/ $content, /*array*/ $footer){
    //ob_start();
    $inv = new InvoicePdf();

    $inv->AddPage('P', [210/2, 220]);
    $inv->addBanner();
    $inv->addHeader($header);
    $inv->addContent($content);
    $inv->addFooter($footer);
    //$inv->Output();

    //$pdfclean = ob_get_clean();
    //$pdf64 =  base64_encode($pdfclean);

    //return $pdf64;
    return $inv->Output('S');
}

function createInvoice(/*int*/ $aptid, /*int*/ $number){

    $header = getInvoiceHeader($aptid, $number);
    $content = getAptContentInvoice($aptid, $number);
    $footer = getAptFootInvoice($aptid, $number);

    $pdf = makePdf($header, $content, $footer);

    //return $pdf64;
    return base64_encode($pdf);
}
