<?php
// Controlador: js/main.js, js/profile.js
// Vista: main.php, user/profile.php

session_start();
require_once '../datos.php';
require_once ROOTDIR.'/server.php';
require_once ROOTDIR.'/core/functions.php';
connect();
$user_id = $_SESSION['user_id'];
$bui_id = $_SESSION['number_id'];

if(isset($_GET['fun'])){
    extract($_GET);
    switch ($fun) {
        case 'load':
            $q = "SELECT udata_name AS 'name', udata_surname AS 'surname', udata_ci AS 'ci', udata_cel AS 'cel', user_user AS 'email', udata_cond AS 'cond', udata_gender AS 'gen' FROM users, userdata WHERE user_id = udata_user_fk AND user_id = $user_id";
            $r = q_exec($q);
            echo toJson($r);
            break;
        case 'notes':
            $q = "SELECT bui_notes FROM buildings, userdata WHERE bui_id = udata_number_fk AND bui_id = $bui_id";
            $r = q_exec($q);
            echo uniqueQuery($r);
            break;
        case 'cel':
            $q = "SELECT udata_cel FROM userdata WHERE udata_user_fk = $user_id";
            $r = q_exec($q);
            echo uniqueQuery($r);
            break;
        case 'quest':
            $q = "SELECT user_question FROM users WHERE user_id = $user_id";
            $r = q_exec($q);
            echo uniqueQuery($r);
            break;
        default:
            # code...
            break;
    }

}

if(isset($_POST['submit'])){
    //print_r($_POST);
    extract($_POST);
    if(isset($edif) && $edif == 'A17'){
        $notes = Array( 'multi' => isset($multi)? true : false,
                        'uni' => isset($uni)? true : false,
                        'abacantv' => isset($abacantv)? $abacantv : false,
                        'tvcantv' => isset($tvcantv)? $tvcantv : false,
                        'telcantv' => isset($telcantv)? $telcantv : false,
                        'gas' => isset($gas)? $gas : false,
                        'directv' => isset($directv)? $directv : false,
                        'cars' => isset($cars)? $cars : false,
                        'motos' => isset($motos)? $motos : false);

        $notes_j = json_encode($notes);
        //print_r($notes_j);
        $q1 = "UPDATE buildings SET bui_notes = '$notes_j' WHERE bui_id = $bui_id";
        $r1 = q_exec($q1);        
    }

    $q2 = "UPDATE userdata SET udata_name = '$name', udata_surname ='$surname', udata_ci = '$ci', udata_cel = '$cel', udata_gender = '$gen' WHERE udata_user_fk = $user_id";
    $r2 = q_exec($q2);
    echo "cambios aplicados";
    header('Location: ../user/profile.php');
}

if(isset($_POST['old']) && isset($_POST['new'])){
    extract($_POST);
    if($old == $new){
        echo '{"status": false, "msg": "Las claves deben ser diferentes"}';
    }else{
        $q1 = "SELECT user_pwd FROM users WHERE user_id = '$user_id'";
        $r1 = q_exec($q1);
        $pwd = uniqueQuery($r1);
        if($pwd != DEF_PWD) $old = md5($old);
        if($pwd == $old){
            $new = md5($new);
            $q2 = "UPDATE users SET user_pwd = '$new' WHERE user_id = '$user_id'";
            $r2 = q_exec($q2);
            echo '{"status": true, "msg": "Cambio de clave exitoso"}';
        }else{
            echo '{"status": false, "msg": "La actual clave no coincide"}';
        }
    }
}

if(isset($_POST['fun']) &&$_POST['fun'] == "changeCel" && isset($_POST['cel'])){
    extract($_POST);
    $q1 = "UPDATE userdata SET udata_cel = '$cel' WHERE udata_user_fk = $user_id";
    $r1 = q_exec($q1);
    if(isset($r1)){
        echo '{"status": true, "msg": "Cambios guardados con éxito"}';
    }else {
        echo '{"status": false, "msg": "No se pudo guardar el número"}';
    }
}

if(isset($_POST['question']) && isset($_POST['answer'])){
    extract($_POST);
    $answer = md5($answer);
    $q = "UPDATE users SET user_question = '$question', user_response = '$answer' WHERE user_id = $user_id";
    $r = q_exec($q);
    if(isset($r)){
        echo '{"status": true, "msg": "Cambios guardados con éxito"}';
    }else {
        echo '{"status": false, "msg": "No se pudo guardar el número"}';
    }
}

if(isset($time_ini)) rec_exec_time($time_ini, __FILE__, __LINE__);
 ?>
