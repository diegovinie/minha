<?php
//Vista: main.php
//Controlador: js/main.js

session_start();
require '../datos.php';
require '../server.php';
$con = connect();

if(isset($_GET['fun'])){
    extract($_GET);
    switch ($fun) {
        case 'oldpwd':
            echo DEF_PWD;
            break;
        case 'new':
            $user = $_SESSION['user_id'];
            $q = "SELECT user_pwd FROM users WHERE user_id = '$user'";
            $r = q_exec($q);
            $pwd = uniqueQuery($r);
            if($pwd == DEF_PWD){
                echo 1;
            }else{
                echo 0;
            }
            break;
        case 'balance':
            $number = $_SESSION['number_id'];
            $q = "SELECT bui_name, bui_apt, bui_balance FROM buildings WHERE bui_id = $number";
            $r = q_exec($q);
            echo toJson($r);
            break;
        default:
            # code...
            break;
    }
}

 ?>
