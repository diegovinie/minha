<?php
require_once '../datos.php';
require_once ROOTDIR.'/server.php';
require_once ROOTDIR.'/core/tables.php';
connect();

extract($_GET);

switch ($arg) {
    case 'usuarios_registrados':
        $q = "SELECT udata_name AS 'Nombre', udata_surname AS 'Apellido',
    	        udata_ci AS 'C.I.',  A17_number AS 'Apartamento',
    			user_user AS 'Correo', CASE user_type
    				WHEN 1 THEN 'Administrador'
    				WHEN 2 THEN 'Usuario'
    				ELSE 'Indeterminado'
    			END AS 'Tipo de Usuario'
    	    FROM users, userdata, A17 WHERE udata_user_fk = user_id AND udata_number_fk = A17_id AND user_active = 1";
        $fun = 'display_users';
        break;
    case 'usuarios_pendientes':
    $q = "SELECT udata_id AS 'id', udata_name AS 'Nombre',
            udata_surname AS 'Apellido',
            udata_ci AS 'C.I.',
            A17_number AS 'Apartamento',
            user_user AS 'Correo'
        FROM users, userdata, A17 WHERE udata_user_fk = user_id AND udata_number_fk = A17_id AND user_active = 0";
    $fun = 'pending_users';
        break;

    default:
        # code...
        break;
}
$fun($q, $arg);

function display_users($q, $id){
    $r = q_exec($q);
    table_open($id);
    table_head($r);
    table_tbody($r);
    table_close();
}

function pending_users($q, $id){
    $r = q_exec($q);
    table_open($id);
    table_head($r);
    table_tbody($r);
    table_close();
}

 ?>
