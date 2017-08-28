<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function setDataApartmentsTable(/*array*/ $apts, /*string*/ $prefix=null){
    $db = connectDb($prefix);
    $prx = $db->getPrx();

    $st = $db->prepare(
        "SELECT bui_id
        FROM {$prx}buildings
        WHERE bui_alias = :edf"
    );
    $db->bindValue('edf', $edf)
    $res = $db->execute();

    $buiid = $db->fetchColumn();

    $stmt = $db->prepare(
        "INSERT INTO {$prx}apartments
        VALUES (
            NULL,
            :name,
            :buiid,
            :edf,
            0,
            :weight,
            :assigned,
            :occupied,
            :notes)"
    );
    $stmt->bindParam('name', $name);
    $stmt->bindParam('buiid', $buiid);
    $stmt->bindParam('edf', $edf);
    $stmt->bindParam('weight', $weight);
    $stmt->bindParam('assigned', $assigned);
    $stmt->bindParam('occupied', $occupied);
    $stmt->bindParam('notes', $notes);

    foreach($apts as $apt){
        extract($apt);

        $exe = $stmt->execute();

        if(!$exe){
            echo $stmt->errorInfo()[2];
            return false;
        }
    }

    return true;
}
