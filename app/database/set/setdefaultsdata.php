<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function setDataAllTable(/*int*/ $simId=1){

    $r1 = setDataProvidersTable($simId);
    $r2 = setDataAccountsTable($simId);
    $r3 = setDataFundsTable($simId);

    return $r1 * $r2 *$r3? true : false;
}

function setDataProvidersTable(/*int*/ $simId=1){
    $db = connectDb();

    $prx = $simId == 1? 'pri_' : "s1_";

    $json = file_get_contents(APPDIR."database/datafixtures/providers.json");
    $providers = json_decode($json, true);



    $stmt = $db->prepare(
        "INSERT INTO {$prx}providers
        (prov_name,     prov_alias,     prov_rif,
         prov_cel,      prov_email,     prov_sim_fk)
        VALUES
        (:name,         :alias,         :rif,
         :cel,          :email,         :simid)"
    );
    $stmt->bindParam('name', $name);
    $stmt->bindParam('alias', $alias);
    $stmt->bindParam('rif', $rif);
    $stmt->bindParam('cel', $cel);
    $stmt->bindParam('email', $email);
    $stmt->bindParam('simid', $simId);

    $stmt2 = $db->prepare(
        "SELECT prov_id
        FROM {$prx}providers
        WHERE prov_name = :name
            AND prov_rif = :rif
            AND prov_sim_fk = :simid"
    );

    $stmt2->bindParam('name', $name);
    $stmt2->bindParam('rif', $rif);
    $stmt2->bindValue('simid', $simId);

    $stmt3 = $db->prepare(
        "INSERT INTO {$prx}skills
        (ski_prov_fk,   ski_act_fk,     ski_quality,
         ski_cost)
        VALUES
        (:provid,       :actid,         :quality,
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

        if($simId > 1){
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

function setDataAccountsTable(/*int*/ $simId=1){
    $db = connectDb();

    $prx = $simId == 1? 'pri_' : "s1_";


    $json = file_get_contents(APPDIR."database/datafixtures/accounts.json");
    $accs = json_decode($json, true);

    $stmt = $db->prepare(
        "INSERT INTO {$prx}accounts
        (acc_name,      acc_balance,    acc_type,
         acc_hab_fk,    acc_max,        acc_bui_fk,
         acc_creator,   acc_sim_fk)
        VALUES
        (:name,         :balance,       :type,
         :hab,          :max,           :bui,
         :creator,      :simid)"
    );
    $stmt->bindParam('name', $name);
    $stmt->bindParam('balance', $balance);
    $stmt->bindParam('type', $type);
    $stmt->bindParam('hab', $hab, PDO::PARAM_INT);
    $stmt->bindParam('max', $max);
    $stmt->bindParam('bui', $bui, PDO::PARAM_INT);
    $stmt->bindParam('creator', $creator);
    $stmt->bindParam('simid', $simId, PDO::PARAM_INT);

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

function setDataFundsTable(/*int*/ $simId=1){
    $db = connectDb();

    $prx = $simId == 1? 'pri_' : "s1_";

    $json = file_get_contents(APPDIR."database/datafixtures/funds.json");
    $funds = json_decode($json, true);

    $stmt = $db->prepare(
        "INSERT INTO {$prx}funds
        (fun_name,  fun_balance,    fun_default,
         fun_type,  fun_bui_fk,     fun_creator,
         fun_sim_fk)
        VALUES
        (:name,     :balance,       :default,
         :type,     :bui,           :creator,
         :simid)"
    );
    $stmt->bindParam('name', $name);
    $stmt->bindParam('balance', $balance);
    $stmt->bindParam('default', $default);
    $stmt->bindParam('type', $type);
    $stmt->bindParam('bui', $bui, PDO::PARAM_INT);
    $stmt->bindParam('simid', $simId, PDO::PARAM_INT);
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
