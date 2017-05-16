<?php
require_once '../datos.php';
require_once ROOTDIR.'/server.php';
require_once ROOTDIR.'/core/tables.php';
connect();

if(isset($_GET['fun'])){
    extract($_GET);
    switch ($arg) {
        case 'proveedores':
            $q = "SELECT up_id AS 'id', up_name AS 'Nombre o Razón Social', up_rif AS 'RIF/CI', up_alias AS 'Alias', spe_name AS 'Tipo' FROM usual_providers INNER JOIN spendings_types ON spe_id = up_fk_type";
            break;
        case 'gastos':
            $q = "SELECT bil_id AS 'id', bil_date AS 'Fecha', bil_class AS 'Clase',
            bil_method AS 'Tipo de Pago', formatEsp(bil_total) AS 'Monto' FROM bills ORDER BY bil_id DESC";
            break;
        case 'mostrar_gasto':
            $q = "SELECT bil_date AS 'Fecha', `bil_class` AS 'Clase',
            `bil_desc` AS 'Descripción', `bil_name` AS 'Proveedor',
            `bil_rif` AS 'RIF/CI', `bil_fk_account`, `bil_method` AS 'Método',
            `bil_log` AS 'Soporte', `bil_lapse_fk` AS 'Periodo',
            formatEsp(bil_amount) AS 'Monto', formatEsp(bil_iva) AS 'IVA', formatEsp(bil_total) AS 'Total' FROM `bills` WHERE bil_id = $id";
            break;
        default:
            die;
            break;
    }

    $fun($q, $arg);
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
