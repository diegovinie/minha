<?php

defined('_EXE') or die('Acceso restringido');

include_once ROOTDIR.'/models/db.php';

function getFractionA17(/*string*/ $bui){
    $db = connectDb();
    $prx = $db->getPrx();

    $stmt = $db->prepare(
        "SELECT bui_id AS 'id', bui_apt AS 'name'
        FROM {$prx}buildings
        WHERE bui_assigned = 1 AND bui_name = :bui"
    );
    $stmt->bindValue('bui', $bui);
    $res = $stmt->execute();

    if(!$res){
        return false;
    }
    else{
        $apts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $lg = $md = $sm = 0;

        $sizes = array( "A" => 3,   "B" => 2,
                        "C" => 2,   "D" => 3,
                        "E" => 2,   "F" => 1,
                        "G" => 1,   "H" => 2);

        foreach ($apts as $ind => $apt) {
            $name = $apt['name'];
            $ltr = $name[strlen($name) - 1];

            if($ltr == "A" || $ltr == "D") $lg++;

            if($ltr == "B" || $ltr == "C" ||
               $ltr == "D" || $ltr == "E") $md++;

            if($ltr == "F" || $ltr == "G") $sm++;
        }

        $frac = 100 / (3*$lg + 2*$md + $sm);

        return $frac;
    }
}

function getFractionCountry_Park(/*string*/ $bui){
    $db = connectDb();
    $prx = $db->getPrx();

    $stmt = $db->prepare(
        "SELECT COUNT(bui_id)
        FROM {$prx}buildings
        WHERE bui_assigned = 1 AND bui_name = :bui"
    );
    $stmt->bindValue('bui', $bui);
    $res = $stmt->execute();

    if(!$res){
        return false;
    }
    else{
        $apts = $stmt->fetchColumn();

        return 100 / $apts;
    }
}
