<?php
/* components/invoices/models/userinvoices.php
 *
 *
 *
 */
defined('_EXE') or die('Acceso restringido');

include_once ROOTDIR.'/models/db.php';

function getBatchList(/*string*/ $edf){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();

    $dir = ROOTDIR."/files/{$prx}invoices/$edf";

    if(!is_dir($dir)){
        //print('Problema con el directorio');
        return false;
    }

    $dirHnd = opendir($dir);
    $batch = array();

    while(false !== ($fileName = readdir($dirHnd))){

        if($fileName == '.' || $fileName == '..') continue;

        list($name, $ext) = split('\.', $fileName);

        if($ext != 'json') continue;

        list($lot, $dat) = split('_', $name);

        if($lot != 'LOT') continue;

        list($batchSimId, $number) = split('-', $dat);

        if($batchSimId == $simid){
            $f = array();

            $month = substr($number, -2, strlen($number));
            $year = substr($number, 0, 4);
            $f['id'] = $number;
            $f['name'] = $month.'/'.$year;
            $batchs[] = $f;
        }
    }
    return $batchs;
}
