<?php
// Controlador: js/invoices.js
// Vista: admin/invoices.php

session_start();
require_once '../datos.php';
require_once ROOTDIR.'/server.php';
require_once ROOTDIR.'/core/functions.php';
connect();
$q2 = '';
extract($_GET);
$bui = $_SESSION['bui'];
switch ($arg) {
    case 'agregar_gastos':
        $q = "SELECT bil_id AS 'id', bil_date AS 'Fecha', bil_class AS 'Clase',
        bil_desc AS 'Desc', bil_total AS 'Monto' FROM bills WHERE bil_bui = '$bui' AND bil_lapse_fk = 0 ORDER BY bil_date DESC";
        break;
    case 'fondos':
        $q = "SELECT fun_id AS 'id', fun_name AS 'Nombre', fun_balance AS 'Saldo', fun_type FROM funds WHERE fun_bui = '$bui' ";
        $q2 = "SELECT fun_type, CONVERT(fun_default, SIGNED) AS 'fun_monto' FROM funds WHERE fun_bui = '$bui'";
        break;

    default:
        # code...
        break;
}

$fun($q, $q2, $arg);

function show_bills($q, $q2, $arg){
    $r_body = q_exec($q);
    table_open($arg);
    table_head($r_body);
    table_tbody($r_body);
    table_close();
}

function show_funds($q, $q2, $arg){
    $r = q_exec($q);
    $r2 = q_exec($q2);
    $r2_asc = query_to_assoc($r2);
    $i = 0;
    while ($row = mysql_fetch_assoc($r)) {
        ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a href="#e_<?php echo $row['id'] ?>" data-toggle="collapse" data-parent="#accordion"><?php echo $row['Nombre'] ?></a>
                </h4>
            </div>
            <div class="panel-body panel-collapse collapse" id="e_<?php echo $row['id'] ?>">
                <div class="well well-sm">
                    <ul style="list-style:none;">
                        <li>Cuota Anterior</li>
                        <li>Saldo Actual</li>
                    </ul>
                </div>
                <table width="100%" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <?php
                            foreach ($row as $key => $value) {
                                ?>
                                <th><?php echo $key; ?></th>
                                <?php
                            }
                             ?>
                        </tr>
                    </thead>
                    <tr>
                        <?php
                        foreach ($row as $key => $value) {
                            ?>
                            <td data-type="<?php echo $key; ?>" data-value="<?php echo $value; ?>"><?php echo $value; ?></td>
                        <?php
                        }
                         ?>
                    </tr>
                </table>
                <?php
                    extract($row);
                 ?>
                <div  class="form-inline" style="margin-top:10px;">
                    <div class="form-group">
                            <input class="form-control checkbox" type="checkbox" name="type_<?php echo $row['id']; ?>" value="<?php echo $fun_type; ?>" onclick="activateOnCheck(this, 'def_<?php echo $id; ?>', 'name_<?php echo $id; ?>')">
                            <label width="50px" for="chk_<?php echo $row['id']; ?>">Incluir
                            </label>
                            <span> | </span>
                            <input type="text" name="name_<?php echo $row['id']; ?>" value="<?php echo $row['Nombre']; ?>" id="name_<?php echo $row['id']; ?>" hidden disabled>

                        <label for="def_<?php echo $row['id']; ?>">Monto: </label>
                        <input class="form-control" type="text" name="def_<?php echo $row['id']; ?>"  id="def_<?php echo $row['id']; ?>" value="<?php echo number_format($r2_asc[$i]['fun_monto'], 2, ',', '.'); ?>" disabled>
                        <span><?php if($r2_asc[$i]['fun_type'] == 1) {echo '%';}else{echo 'Bs';}?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $i++;
    }

}
 ?>
