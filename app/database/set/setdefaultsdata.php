<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function setDataProvidersTable(/*string*/ $prefix=null){
    $db = connectDb();
    $prx = $prefix? $prefix : 'pri_';

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

function setDataAccountsTable(/*string*/ $prefix=null){
  $db = connectDb();
  $prx = $prefix? $prefix : 'pri_';

    $json = file_get_contents(APPDIR."database/datafixtures/accounts.json");
    $accs = json_decode($json, true);

    $stmt = $db->prepare(
        "INSERT INTO {$prx}accounts
        VALUES (
            NULL,
            :name,
            :balance,
            :type,
            :hab,
            :max,
            :bui,
            :creator,
            NULL)"
    );
    $stmt->bindParam('name', $name);
    $stmt->bindParam('balance', $balance);
    $stmt->bindParam('type', $type);
    $stmt->bindParam('hab', $hab, PDO::PARAM_INT);
    $stmt->bindParam('max', $max);
    $stmt->bindParam('bui', $bui, PDO::PARAM_INT);
    $stmt->bindParam('creator', $creator);

    foreach($accs as $acc){
        extract($acc);

        $exe = $stmt->execute();

        if(!$exe){
            echo $stmt->errorInfo()[2];
            return false;
        }
    }

    return true;
}

function setDataFundsTable(/*string*/ $prefix=null){
  $db = connectDb();
  $prx = $prefix? $prefix : 'pri_';

    $json = file_get_contents(APPDIR."database/datafixtures/funds.json");
    $funds = json_decode($json, true);

    $stmt = $db->prepare(
        "INSERT INTO {$prx}funds
        VALUES (
            NULL,
            :name,
            :balance,
            :default,
            :type,
            :bui,
            :creator,
            NULL)"
    );
    $stmt->bindParam('name', $name);
    $stmt->bindParam('balance', $balance);
    $stmt->bindParam('default', $default);
    $stmt->bindParam('type', $type);
    $stmt->bindParam('bui', $bui, PDO::PARAM_INT);
    $stmt->bindParam('creator', $creator);

    foreach($funds as $fund){
        extract($fund);

        $exe = $stmt->execute();

        if(!$exe){
            echo $stmt->errorInfo()[2];
            return false;
        }
    }

    return true;
}
