<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function setDataAllTable(/*string*/ $prefix=null){

    $r1 = setDataProvidersTable($prefix);
    $r2 = setDataAccountsTable($prefix);
    $r3 = setDataFundsTable($prefix);
    
    return $r1 * $r2 *$r3? true : false;
}

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

    $stmt2 = $db->prepare(
        "SELECT prov_id
        FROM {$prx}providers
        WHERE prov_name = :name
            AND prov_rif = :rif"
    );

    $stmt2->bindParam('name', $name);
    $stmt2->bindParam('rif', $rif);

    $stmt3 = $db->prepare(
        "INSERT INTO {$prx}skills
        VALUES (
            NULL,
            :provid,
            :actid,
            :quality,
            :cost)"
    );
    $stmt3->bindParam('provid', $provid, PDO::PARAM_INT);
    $stmt3->bindParam('actid', $id, PDO::PARAM_INT);
    $stmt3->bindParam('quality', $quality, PDO::PARAM_INT);
    $stmt3->bindParam('cost', $cost);


    foreach($providers as $provider){
        extract($provider);

        $exe = $stmt->execute();

        if(!$exe){
            echo $stmt->errorInfo()[2];
            return false;
        }

        if($prefix){
            $stmt2->execute();
            $provid = $stmt2->fetchColumn();

            if(!$provid){
                echo $stmt2->errorInfo()[2];
                return false;
            }

            foreach ($skills as $skill) {
                extract($skill);
                $exe3 = $stmt3->execute();

                if(!$exe3){
                    echo $stmt3->errorInfo()[2];
                    return false;
                }
            }
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
