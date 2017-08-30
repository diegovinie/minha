<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function setDataProvidersTable(/*string*/ $prefix=null){
    $db = connectDb($prefix);
    $prx = $db->getPrx();

    $json = file_get_contents(APPDIR."database/datafixtures/providers.json");
    $providers = json_decode($json, true);

    $stmt = $db->prepare(
        "INSERT INTO {$prx}providers
        VALUES (
            NULL,
            :name,
            :alias,
            :rif,
            :cel,
            :email)"
    );
    $stmt->bindParam('name', $name);
    $stmt->bindParam('alias', $alias);
    $stmt->bindParam('rif', $rif);
    $stmt->bindParam('cel', $cel);
    $stmt->bindParam('email', $email);    

    foreach($providers as $provider){
        extract($provider);

        $exe = $stmt->execute();

        if(!$exe){
            echo $stmt->errorInfo()[2];
            return false;
        }
    }

    return true;
}
