<?php
// Controlador: js/balance.js
// Vista: admin/balance.php

session_start();
require_once '../datos.php';
require_once ROOTDIR.'server.php';
require_once ROOTDIR.'core/functions.php';
connect();
extract($_GET);
$bui = $_SESSION['bui'];

print_r($fun($number));

function balance($number){
    $q = "SELECT bui_name, bui_apt, bui_balance FROM buildings WHERE bui_id = $number";
    $r = q_exec($q);
    $r_a = query_to_assoc($r);
    $r_j = json_encode($r_a);
    return $r_j;
}

function show_apt($number){
    $q = "SELECT bui_apt AS `Apto`, bui_balance AS `Deuda`, bui_assigned AS `Asignado?`, bui_occupied, sum(ifzero(pay_check)) AS `Pagos por chequear`, sum(iftwo(pay_check)) AS `Pagos devueltos` FROM buildings, payments WHERE bui_id = '$number' AND pay_fk_number = '$number' AND bui_name = '$bui'";
    $r = q_exec($q);
    $r_ar = query_to_assoc($r);
    $r_j = json_encode($r_ar);
    return $r_j;
}

function show_users($number){
    $q = "SELECT udata_name AS Nombre, udata_surname AS Apellido, udata_ci AS `C.I.` FROM userdata WHERE udata_number_fk = '$number'";
    $r = q_exec($q);
    $r = q_exec($q);
    $r_ar = query_to_assoc($r);
    $r_j = json_encode($r_ar);
    return $r_j;
}

function sel_lapse($vacio){
    $q = "SELECT * FROM lapses ORDER BY lap_id DESC LIMIT 3";
    $r = q_exec($q);
    $r_ar = query_to_assoc($r);
    $r_j = json_encode($r_ar);
    return $r_j;
}

function checkmail($number){
    $q = "SELECT user_id FROM users WHERE user_user = '$number'";
    $r = q_exec($q);
    $r_a = query_to_array($r);
    return sizeof($r_a);
}
