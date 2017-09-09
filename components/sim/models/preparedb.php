<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function getUserId($simEmail){
    $db = connectDb();

    ///// Preparación de consultas

    // Inserta el simulador en users
    $stmt = $db->prepare(
        "INSERT INTO `glo_users`
        (user_user, user_pwd, user_active, user_creator)
        VALUES
        (:user,     :pwd,     1,           'system')"
    );
    $stmt->bindValue('user', $simEmail);
    $stmt->bindValue('pwd', DEF_PWD);

    // Selecciona el id del simulador en users
    $stmt1 = $db->prepare(
        "SELECT user_id
        FROM glo_users
        WHERE user_user = :user
        ORDER BY user_id DESC
        LIMIT 1"
    );
    $stmt1->bindValue('user', $simEmail);

    ///// Inicio de la ejecución

    $res = $stmt->execute();

    if(!$res){
        print_r($stmt->errorInfo());
        return false;
    }

    $res1 = $stmt1->execute();

    if(!$res1){
        print_r($stmt1->errorInfo());
        return false;
    }

    return $userid = $stmt1->fetchColumn();
}

function setApartmentsData($prx, $apts, $simId){
    $db = connectDb();

    $st = $db->prepare(
        "SELECT bui_id
        FROM glo_buildings
        WHERE bui_edf = :edf"
    );
    $st->bindParam('edf', $edf);


    $stmt = $db->prepare(
        "INSERT INTO {$prx}apartments
        (apt_name,   apt_bui_fk,    apt_edf,      apt_balance,
         apt_weight, apt_assigned,  apt_occupied, apt_notes,
         apt_sim_fk)
        VALUES
        (:name,      :buiid,        :edf,         0,
         :w,         :assigned,     :occupied,    :notes,
         :simid)"
    );

    foreach ($apts as $id => $apt) {
        $stmt->bindParam('name', $name);
        $stmt->bindParam('buiid', $buiid);
        $stmt->bindParam('edf', $edf);
        $stmt->bindParam('w', $weight);
        $stmt->bindParam('assigned', $assigned, PDO::PARAM_INT);
        $stmt->bindParam('occupied', $occupied, PDO::PARAM_INT);
        $stmt->bindParam('notes', $notes);
        $stmt->bindParam('simid', $simId);

        extract($apt);

        $qry = $st->execute();

        $buiid = $st->fetchColumn();

        $exe = $stmt->execute();

        if(!$exe){
            echo $stmt->errorInfo()[2];
            return false;
        }
    }

    return true;
}

function setHabitantsData($prx, $cmty, $simId){
    $db = connectDb();

    ///// Preparación de consultas

    // Selecciona el id del apartamento
    $stmt2 = $db->prepare(
        "SELECT apt_id
        FROM {$prx}apartments
        WHERE apt_edf = :edf
        AND apt_name = :apt
        AND apt_sim_fk = :simid"
    );
    $stmt2->bindParam('apt', $aptname);
    $stmt2->bindParam('edf', $aptedf);
    $stmt2->bindValue('simid', $simId);

    // Inserta datos en habitants
    $stmt3 = $db->prepare(
        "INSERT INTO `{$prx}habitants`
        (hab_name, hab_surname, hab_ci,         hab_cel,
         hab_cond, hab_role,    hab_accepted,   hab_gender,
         hab_nac,  hab_apt_fk,  hab_email)
        VALUES
        (:name,    :surname,    :ci,            :cel,
         :cond,    :role,       :accepted,      :gender,
         :nac,     :apt_id,     :email)"
    );
    $stmt3->bindParam('name', $name);
    $stmt3->bindParam('surname', $surname);
    $stmt3->bindParam('ci', $ci);
    $stmt3->bindParam('cel', $cel);
    $stmt3->bindParam('cond', $cond);
    $stmt3->bindParam('role', $role);
    $stmt3->bindParam('accepted', $accepted);
    $stmt3->bindParam('gender', $gender);
    $stmt3->bindParam('nac', $nac);
    $stmt3->bindParam('apt_id', $apt_id);
    $stmt3->bindParam('email', $email);

    ////// Inicio de la ejecución

    foreach ($cmty as $apt) {

        if(isset($apt['habs'])){

            foreach ($apt['habs'] as $hab) {
                //var_dump($hab);
                extract($hab);

                $aptname = $apt['name'];
                $aptedf = $apt['edf'];

                $exe2 = $stmt2->execute();

                if(!$exe2){
                    echo $stmt2->errorInfo()[2];
                    return false;
                }

                $res2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                //var_dump($res2); die;
                extract($res2);

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

function setAccountsData($habId, $simId){
    $db = connectDb();
    $prx = 's1_';

    $accounts = array(
        array(
            'name' => "BANCO DE VENEZUELA 0102-0433-99-0044556677",
            'balance' => 100000.00,
            'type' => 'principal',
            'default' => null,
            'op' => null
        ),
        array(
            'name' => "Fondo de Trabajo",
            'balance' => 0.00,
            'default'  => "10",
            'type'  => 'fondo',
            'op' => 1
        ),
        array(
            'name' => "Fondo Especial",
            'balance' => 0.00,
            'default'  => "50000",
            'type'  => 'fondo',
            'op' => 2
        )
    );

    $creator = 'system';

    $stmt1 = $db->prepare(
        "SELECT apt_bui_fk
        FROM {$prx}apartments
            INNER JOIN {$prx}habitants ON hab_apt_fk = apt_id
        WHERE hab_id = :habId"
    );
    $stmt1->bindValue('habId', $habId);
    $res1 = $stmt1->execute();

    if(!$res1){
        echo "en 1: ". $stmt1->errorInfo()[2];
        return false;
    }

    $buiid = $stmt1->fetchColumn();

    $stmt3 = $db->prepare(
        "SELECT s.type_id
        FROM glo_types s
            INNER JOIN glo_types d ON d.type_id = s.type_ref
        WHERE d.type_name = 'acc_type'
            AND s.type_name = :type"
    );
    $stmt3->bindParam('type', $type);

    $stmt4 = $db->prepare(
        "INSERT INTO {$prx}accounts
        (acc_name,      acc_balance,    acc_type_fk,
         acc_hab_fk,    acc_default,    acc_bui_fk,
         acc_creator,   acc_sim_fk,     acc_op)
        VALUES
        (:name,         :balance,       :type,
         :habid,        :default,       :bui,
         :creator,      :simid,         :op)"
    );
    $stmt4->bindParam('name', $name);
    $stmt4->bindParam('balance', $balance);
    $stmt4->bindParam('type', $typeid, PDO::PARAM_INT);
    $stmt4->bindParam('habid', $habId, PDO::PARAM_INT);
    $stmt4->bindParam('default', $default);
    $stmt4->bindParam('bui', $buiid, PDO::PARAM_INT);
    $stmt4->bindParam('creator', $creator);
    $stmt4->bindParam('simid', $simId, PDO::PARAM_INT);
    $stmt4->bindParam('op', $op,  PDO::PARAM_INT);

    foreach ($accounts as $acc) {
        extract($acc);

        $res3 = $stmt3->execute();

        if(!$res3){
            echo "en 3: ". $stmt3->errorInfo()[2];
            return false;
        }

        $typeid = $stmt3->fetchColumn();

        $exe4 = $stmt4->execute();

        if(!$exe4){
            echo "en 4: ". $stmt4->errorInfo()[2];
            return false;
        }
    }

    return true;
}

function setFundsData($habId, $simId){
    $db = connectDb();
    $prx = 's1_';

    $funds = array(
        array(
            'name' => "Fondo de Trabajo",
            'default'  => "10",
            'type'  => 1
        ),
        array(
            'name' => "Fondo Especial",
            'default'  => "50000",
            'type'  => 2
        )
    );

    $stmt = $db->prepare(
        "SELECT apt_bui_fk
        FROM {$prx}habitants
            INNER JOIN {$prx}apartments ON hab_apt_fk = apt_id
        WHERE hab_id = :habid"
    );
    $stmt->bindValue('habid', $habId, PDO::PARAM_INT);

    $res = $stmt->execute();

    if(!$res){
        echo $stmt->errorInfo()[2];
        return false;
    }
    else{
        $buiid = $stmt->fetchColumn();
    }

    $stmt2 = $db->prepare(
        "INSERT INTO {$prx}funds
        (fun_name,      fun_balance,        fun_default,
         fun_type,      fun_bui_fk,         fun_sim_fk,
         fun_creator)
        VALUES
        (:name,         0.00,               :default,
         :type,         :buiid,             :simid,
         'system')"
    );
    $stmt2->bindParam('name', $name);
    $stmt2->bindParam('default', $default);
    $stmt2->bindParam('type', $type);
    $stmt2->bindValue('buiid', $buiid, PDO::PARAM_INT);
    $stmt2->bindValue('simid', $simId, PDO::PARAM_INT);

    foreach ($funds as $fund) {
        extract($fund);
        $res2 = $stmt2->execute();

        if(!$res2){
            echo $stmt2->errorInfo()[2];
            return false;
        }
    }
    return true;
}
