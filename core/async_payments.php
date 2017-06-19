<?php
require_once '../datos.php';
require_once ROOTDIR.'/server.php';
require_once ROOTDIR.'/core/tables.php';
connect();

if(isset($_GET['fun'])){
    extract($_GET);
    switch ($arg) {
        case 'mes_actual':
            $q = "SELECT CASE pay_check
                        WHEN 1 THEN 'Aprobados'
                        WHEN 2 THEN 'Rechazados'
                        WHEN 0 THEN 'Pendientes'
                        END AS 'Condición', COUNT(pay_id) AS 'Cantidad', SUM(pay_amount) AS 'Monto' FROM payments WHERE MONTH(pay_date) = MONTH(NOW()) GROUP BY pay_check";
            break;
        case 'mes_anterior':
            $q = "SELECT CASE pay_check
                        WHEN 1 THEN 'Aprobados'
                        WHEN 2 THEN 'Rechazados'
                        WHEN 0 THEN 'Pendientes'
                        END AS 'Condición', COUNT(pay_id) AS 'Cantidad', SUM(pay_amount) AS 'Monto' FROM payments WHERE MONTH(pay_date) = MONTH(NOW())-1 GROUP BY pay_check";
            break;
        case 'ultimos_tres':
            $q = "SELECT lap_name AS 'Mes', SUM(pay_amount)
                AS 'Monto' FROM payments INNER JOIN lapses ON MONTH(pay_date) = lap_id WHERE pay_check = 0 GROUP BY lap_name LIMIT 3";
            break;
        case 'pagos_rechazados':
            $q = "SELECT pay_id AS 'id', pay_date AS 'Fecha', bui_apt
                AS 'Apartamento', pay_amount AS 'Monto',
                    CASE pay_type
                        WHEN 1 THEN 'Transferencia'
                        WHEN 2 THEN 'Depósito'
                ELSE 'otro'
                END AS 'Forma de Pago',
                bank_name AS 'Banco', pay_op AS 'Num. Op.', pay_obs AS 'Observaciones' FROM payments
                INNER JOIN buildings ON pay_fk_number = bui_id
                INNER JOIN banks ON pay_fk_bank = bank_id
                WHERE pay_check = 2
                LIMIT 0, 10";
            break;
        case 'pagos_pendientes':
            $q = "SELECT pay_id AS 'id', pay_date AS 'Fecha', bui_apt
                AS 'Apartamento', pay_amount AS 'Monto',
                    CASE pay_type
                        WHEN 1 THEN 'Transferencia'
                        WHEN 2 THEN 'Depósito'
                ELSE 'otro'
                END AS 'Forma de Pago',
                bank_name AS 'Banco', pay_op AS 'Num. Op.' FROM payments
                INNER JOIN buildings ON pay_fk_number = bui_id
                INNER JOIN banks ON pay_fk_bank = bank_id
                WHERE pay_check = 0
                ";
            break;
        case 'pagos_aprobados':
        $q = "SELECT pay_id AS 'id', pay_date AS 'Fecha', bui_apt
            AS 'Apartamento', pay_amount AS 'Monto',
                CASE pay_type
                    WHEN 1 THEN 'Transferencia'
                    WHEN 2 THEN 'Depósito'
            ELSE 'otro'
            END AS 'Forma de Pago',
            bank_name AS 'Banco', pay_op AS 'Num. Op.' FROM payments
            INNER JOIN buildings ON pay_fk_number = bui_id
            INNER JOIN banks ON pay_fk_bank = bank_id
            WHERE pay_check = 1
            LIMIT 0, 10";
        break;
        default:
            die;
            break;
    }

    $fun($q, $arg);
}

if(isset($_POST['submits'])){
    //extract($_POST);

    if(sizeof($_POST) == 1){        // Si es 1 es porque no se seleccionó nada
        ?>
        <script type="text/javascript">
            window.location.href = "<?php echo PROJECT_HOST;?>admin/payments.php";
        </script>
        <?php
        die;
    }

    $temp_1 = '';
    $temp_2 = '';
    foreach ($_POST as $key => $value) {
        if($value == 1){
            $temp_1 .= "pay_id = '$key'"." OR ";
        }elseif ($value == 2) {
            $temp_2 .= "pay_id = '$key'"." OR ";
        }
    }
    $arg1 = substr($temp_1, 0, strripos($temp_1, "OR"));
    $arg2 = substr($temp_2, 0, strripos($temp_2, "OR"));
    $notes = [];
    foreach ($_POST as $key => $value) {
        if (strpos($key, '_') == 4){
            $notes[substr($key, 5)] = $value;
        }
    }

    if($temp_1 != ''){
        // Se acepta el pago, se actualiza la tabla payments
        $q2_1 = "UPDATE payments SET pay_check = 1 WHERE $arg1";
        $r2_1 = q_exec($q2_1);

        $q4 = "SELECT pay_fk_number, pay_amount FROM payments WHERE $arg1";
        $r4 = q_exec($q4);

        while($row = mysql_fetch_array($r4)){
            // Se actualiza el balance del apartamento
            $qw = "UPDATE buildings SET bui_balance = bui_balance + $row[1] WHERE bui_id = '$row[0]'";
            $rw = q_exec($qw);
            // Se actualiza la cuenta principal
            $qw2 = "UPDATE accounts SET acc_balance = acc_balance + $row[1] WHERE acc_id = 1";
            $rw2 = q_exec($qw2);
        }
    }

    if($temp_2 != ''){
        // Se regresa el pago. Falta definir $obs
        $q2_2 = "UPDATE payments SET pay_check = 2 WHERE $arg2";
        $r2_2 = q_exec($q2_2);
        foreach ($notes as $key => $value) {
            $q2_3 = "UPDATE payments SET pay_obs = '$value' WHERE pay_id = $key";
            $r2_3 = q_exec($q2_3);
        }
    }
    ?>
    <script src="<?php echo PROJECT_HOST;?>js/modal.js" charset="utf-8"></script>
    <script type="text/javascript">

        window.location.href = '<?php echo PROJECT_HOST;?>admin/payments.php';
    </script>
    <?php
}


function aQuery($q, $id){
    $r = q_exec($q);
    tabla1($r, $id);
}

function aQueryTablaPrin($q, $id){
    $r = q_exec($q);
    tabla_radio($r, $id);
}


 ?>
