<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function deleteSim(/*string*/ $prefix){
    $db = connectDb();
    $prx =$prefix;
    $db->exec("SET FOREIGN_KEY_CHECKS=0");

    $userTableNames = array(
        'apartments',
        'subjects',
        'providers',
        'funds',
        'habitants',
        'accounts',
        'bills',
        'charges',
        'payments',
        'commitments'
    );

    foreach ($userTableNames as $gameTable) {

      $stmt = $db->prepare("DROP TABLE {$prx}$gameTable");
      $exe = $stmt->execute();

      if(!$exe){
          echo $stmt->errorInfo()[2];
          return false;
      }
      else{
        echo "$gameTable: $exe\n";
      }
    }


    $id = (int)preg_replace("/[^0-9]+/", "", $prefix);

    echo "Eliminando usuario $id\n\n";

    $stmt2 = $db->prepare(
      "DELETE FROM glo_simulator
      WHERE sim_id = :id"
    );
    $stmt2->bindValue('id', $id, PDO::PARAM_INT);
    $exe2 = $stmt2->execute();

    if(!$exe2){
        echo $stmt2->errorInfo()[2];
        return false;
    }

    $email = "sim_$id@".DB_SMTP;

    $stmt3 = $db->prepare(
      "UPDATE glo_users
      SET user_active = 0
      WHERE user_user = :email"
    );
    $stmt3->bindValue('email', $email);

    $exe3 = $stmt3->execute();

    if(!$exe3){
        echo $stmt3->errorInfo()[2];
        return false;
    }

    $db->exec("SET FOREIGN_KEY_CHECKS=1");

    return true;
}
