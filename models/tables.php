<?php
/* models/tables.php
 *
 * Funciones que modifican los resultados de los queries
 * de la base de datos.
 * Retorna varios tipos
 */

defined('_EXE') or die('Acceso restringido');

function setTheadTbodyFromPDO(PDOStatement $objStmt){
    foreach ($objStmt->fetchAll(PDO::FETCH_NUM) as $ind => $row) {
        foreach ($row as $key => $val) {
            $tbody[$ind][$key] = $val;
            if($ind == 0){
                $thead[$key] = $objStmt->getColumnMeta($key)['name'];
            }
        }
    }
    if(isset($thead) && isset($tbody)){
        return array('thead' => $thead, 'tbody' => $tbody);
    }else{
        return false;
    }
}

function setTheadTbodyTfootFromPDO( PDOStatement $theadTbodyPDO,
                                    PDOStatement $tfootPDO){

    $table = setTheadTbodyFromPDO($theadTbodyPDO);

    foreach ($tfootPDO->fetch(PDO::FETCH_ASSOC) as $key => $value) {
        $tfoot[] = $value;
    }

    if(!isset($tfoot)){
        return false;
    }
    else{
        $table['tfoot'] = $tfoot;
        return $table;
    }
}
