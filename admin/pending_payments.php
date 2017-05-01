<?php
require '../header.php';
require '../server.php';
connect();

$q1 = "SELECT pay_id, pay_date, A17_number, pay_type, pay_op, bank_name, pay_amount, pay_obs FROM payments, A17, banks WHERE pay_check = 0 AND pay_fk_number = A17_id AND pay_fk_bank = bank_id";
$r1 = q_exec($q1);

 ?>
<form class="" action="pending_payments.php" method="post">
    <table class="dynTable">
        <tr class="dynTableHeader"> <td>Aceptar</td><td>rechazar</td> <?php
        for ($i = 0; $i < mysql_num_fields($r1); $i++) {
            ?><td align="center"><?php echo mysql_field_name($r1, $i) ?></td><?php
        }
        ?></tr>
        <?php while($row = mysql_fetch_assoc($r1)){
            ?><tr>
                <td align="center"><input type="radio" name="<?php echo $row['pay_id']; ?>" value="1"></td>
                <td align="center"><input type="radio" name="<?php echo $row['pay_id']; ?>" value="2"></td>

                <?php foreach ($row as $key => $value) {
                    ?><td align="center"><?php echo $value ?></td>
                    <?php
                }
                ?>
                </tr>
                <?php
        } ?>
    </table>

    <div class="button_box" align="center">
        <button type="submit" name="submits" class="button_hot principal">Enviar</button>
        <button type="reset" class="button_hot">Deshacer</button>
        <button type="button" class="button_hot secundary" onclick="history.go(-1)">Regresar</button>
    </div>
</form>
<?php


if (isset($_POST['submits'])) {
    if(sizeof($_POST) == 1){
        ?>
        <script type="text/javascript">
            window.location.href = "pending_payments.php";
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

    if($temp_1 != ''){
        $q2_1 = "UPDATE payments SET pay_check = 1 WHERE $arg1";
        $r2_1 = q_exec($q2_1);

        extract($_POST);
        $q4 = "SELECT pay_fk_number, pay_amount FROM payments WHERE $arg1";
        $r4 = q_exec($q4);

        $arg4 = '';
        while($row = mysql_fetch_array($r4)){
            $arg4 .= "(NULL, $row[0], -$row[1], NULL, 'diego'),\n";
        }
        $arg4 = substr($arg4, 0, strripos($arg4, ","));
        $q3 = "INSERT INTO charges VALUES $arg4";
        $q3 = q_exec($q3);
    }

    if($temp_2 != ''){
        $q2_2 = "UPDATE payments SET pay_check = 2 WHERE $arg2";
        $r2_2 = q_exec($q2_2);
    }
    ?>
    <script type="text/javascript">
        alert("Cambios realizados con éxito");
        window.location.href = "pending_payments.php";
    </script>
    <?php
}
require '../footer.php';
 ?>
