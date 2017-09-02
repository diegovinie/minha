<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function setDataAllTable(){

    $re[] = setDataBanksTable();
    $re[] = setDataLapsesTable();
    $re[] = setDataTypesTable();
    $re[] = setDataBuildingsTable();
    $re[] = setDataSimulatorTable();
    // Inserta los datos por defecto para las actividades en BD
    $re[] = setDataActypesTable();
    $re[] = setDataActivitiesTable();

    return array_sum($re) == count($re)? true : print_r($re);

}

function setDataBanksTable(){
    $db = connectDb();

    $json = file_get_contents(APPDIR."database/datafixtures/banks.json");
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
                && $n + 1 == $curMonth) break;
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
        'apartments',
        'habitants',
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
    $stmt->bindParam('type', $type);

    foreach($types as $type){

        $exe = $stmt->execute();

        if(!$exe){
            echo $stmt->errorInfo()[2];
            return false;
        }
    }

    return true;
}

function setDataBuildingsTable(){
    $db = connectDb();

    $json = file_get_contents(APPDIR."database/datafixtures/buildings.json");
    $buis = json_decode($json, true);

    $stmt = $db->prepare(
        "INSERT INTO glo_buildings
        VALUES (
            NULL,
            :name,
            :edf,
            :num,
            :levels,
            :parking,
            :cons,
            :ofi,
            :gardens,
            :notes)"
    );
    $stmt->bindParam('name', $name);
    $stmt->bindParam('edf', $alias);
    $stmt->bindParam('num', $num);
    $stmt->bindParam('levels', $levels);
    $stmt->bindParam('parking', $parking);
    $stmt->bindParam('cons', $cons);
    $stmt->bindParam('ofi', $ofi);
    $stmt->bindParam('gardens', $gardens);
    $stmt->bindParam('notes', $notes);

    foreach($buis as $bui){
        extract($bui);

        $notes = json_encode($bui['notes']);

        $exe = $stmt->execute();

        if(!$exe){
            echo $stmt->errorInfo()[2];
            return false;
        }
    }

    return true;
}

function setDataSimulatorTable(){
    $db = connectDb();

    $exe = $db->exec(
        "INSERT INTO glo_simulator
        (sim_id,    sim_user,    sim_user_fk)
        VALUES
        (1,         'PRINCIPAL', NULL)"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
        return false;
    }

    return true;
}

include_once ROOTDIR.'/models/db.php';

function setDataActypesTable(){
    $db = connectDb();
    //$db->exec("SET FOREIGN_KEY_CHECKS=0");

    //$db->exec("TRUNCATE sim_actypes");

    $json = file_get_contents(APPDIR."database/datafixtures/actypes.json");
    $actypes = json_decode($json, true);

    $stmt = $db->prepare(
        "INSERT INTO glo_actypes
        VALUES (
            :id,
            :name,
            :op)"
    );
    $stmt->bindParam('name', $name);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->bindParam('op', $op);

    foreach($actypes as $actype){
        extract($actype);

        $exe = $stmt->execute();

        if(!$exe){
            echo $stmt->errorInfo()[2];
            return false;
        }
    }
    $db->exec("SET FOREIGN_KEY_CHECKS=1");

    return true;
}

function setDataActivitiesTable(){
    $db = connectDb();
    $db->exec("SET FOREIGN_KEY_CHECKS=0");

    $db->exec("TRUNCATE sim_actypes");

    $json = file_get_contents(APPDIR."database/datafixtures/activities.json");
    $activities = json_decode($json, true);

    $stmt = $db->prepare(
        "INSERT INTO glo_activities
        VALUES (
            NULL,
            :name,
            :type,
            :affinity)"
    );
    $stmt->bindParam('name', $name);
    $stmt->bindParam('type', $type, PDO::PARAM_INT);
    $stmt->bindParam('affinity', $affinity);

    foreach($activities as $activity){
        extract($activity);

        $exe = $stmt->execute();

        if(!$exe){
            echo $stmt->errorInfo()[2];
            return false;
        }
    }
    $db->exec("SET FOREIGN_KEY_CHECKS=1");

    return true;
}
