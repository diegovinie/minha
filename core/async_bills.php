<?php
// Contolador: js/bills.js
// Vista: admin/bills.php

session_start();
require_once '../datos.php';
require_once ROOTDIR.'/server.php';
require_once ROOTDIR.'/core/functions.php';
connect();

if(isset($_GET['fun'])){
    extract($_GET);
    $bui = $_SESSION['bui'];
    if(!isset($arg)) $arg = $fun; $fun = 'aQuery';
    switch ($arg) {
        case 'proveedores':
            $q = "SELECT up_id AS 'id', up_name AS 'Nombre o Razón Social', up_rif AS 'RIF/CI', up_alias AS 'Alias', spe_name AS 'Tipo' FROM usual_providers INNER JOIN spendings_types ON spe_id = up_fk_type AND up_bui = '$bui'";
            break;
        case 'gastos':
            $q = "SELECT bil_id AS 'id', bil_lapse_fk AS 'Cargado', bil_date AS 'Fecha', bil_class AS 'Clase',
            bil_desc AS 'Desc.', bil_total AS 'Monto' FROM bills
            WHERE bil_bui = '$bui' ORDER BY bil_date DESC";
            break;
        case 'mostrar_gasto':
            $q = "SELECT bil_date AS 'Fecha', `bil_class` AS 'Clase',
            `bil_desc` AS 'Descripción', `bil_name` AS 'Proveedor',
            `bil_rif` AS 'RIF/CI',
            CASE bil_fk_account WHEN 1 THEN 'Principal' WHEN 2 THEN 'Caja Chica' END AS 'Cuenta', `bil_method` AS 'Método',
            `bil_log` AS 'Soporte', bil_amount AS 'Monto', bil_iva AS 'IVA', bil_total AS 'Total' FROM `bills`
            WHERE bil_id = $id AND bil_bui = '$bui'";
            break;
        default:
            die;
            break;
    }
    isset($wrapper)? $wrapper($fun, $q, $arg) : $fun($q, $arg);
}
function aQuerySimple($q){
    $r = q_exec($q);
    $r_ar = query_to_assoc($r);
    $r_j = json_encode($r_ar);
    print_r($r_j);
}
function aQuery($q, $id){
    $r = q_exec($q);
    tabla1($r, $id);
}
function aQueryTbody($q, $id){
    $r = q_exec($q);
    table_body_only($r, $id);
}

 ?>
