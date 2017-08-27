<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function setDataBanksTable(){
    $db = connectDb();

    $json = file_get_contents("datafixtures/banks.json");
    $banks = json_decode($json, true);

    $stmt = $db->prepare(
        "INSERT INTO glo_banks
        VALUES (
            NULL,
            :name,
            :rif,
            :op,
            :prefix)"
    );
    $stmt->bindParam('name', $name);
    $stmt->bindParam('rif', $rif);
    $stmt->bindParam('op', $op);
    $stmt->bindParam('prefix', $prefix);

    foreach($banks as $bank){
        extract($bank);

        $exe = $stmt->execute();

        if(!$exe){
            echo $stmt->errorInfo()[2];
            return false;
        }
    }

    return true;
}

function setDataLapsesTable(){
    $db = connectDb();

    $months = array(
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    );

    $date = new DateTime;
    $curMonth = $date->format('m');
    $curYear = $date->format('Y');

    $lapses = array();

    for ($y=2017; $y < $curYear+1; $y++) {

        foreach ($months as $n => $m) {
            $row = array();

            $row['name'] = "$m $y";
            $row['month'] = $n + 1;
            $row['year'] = $y;

            $lapses[] = $row;

            if($y == $curYear
                && $n + 1 = $curMonth) break;
        }
    }

    $stmt = $db->prepare(
        "INSERT INTO glo_lapses
        VALUES (
            NULL,
            :name,
            :month,
            :year)"
    );
    $stmt->bindParam('name', $name);
    $stmt->bindParam('month', $month);
    $stmt->bindParam('year', $year);

    foreach($lapses as $lapse){
        extract($lapse);

        $exe = $stmt->execute();

        if(!$exe){
            echo $stmt->errorInfo()[2];
            return false;
        }
    }

    return true;
}

function setDataTypesTable(){
    $db = connectDb();

    $types = array(
        'lapses',
        'banks',
        'cookies',
        'game',
        'buildings',
        'subjects',
        'users',
        'providers',
        'funds',
        'accounts',
        'bills',
        'charges',
        'payments',
        'commitments'
    );

    $stmt = $db->prepare(
        "INSERT INTO glo_types
        VALUES (
            NULL,
            :type)"
    );
    $stmt->bindParam('type', $types);

    foreach($types as $type){

        $exe = $stmt->execute();

        if(!$exe){
            echo $stmt->errorInfo()[2];
            return false;
        }
    }

    return true;
}
