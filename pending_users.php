<?php
session_start();
require 'header.php';
require 'menu.php';
?>
<h2 align="center">Usuarios Pendiente por Activación</h2>
<form class="" action="pending_users.php" method="post">
    <table align="center" border="1">
    <?php
    require 'server.php';
    connect();

    $q = "SELECT udata_name AS 'Nombre',
    		udata_surname AS 'Apellido',
            udata_ci AS 'C.I.',
            udata_number AS 'Apartamento',
    		user_user AS 'Correo'
        FROM users, userdata WHERE fk_user = user_id AND user_active = 0";
    $r = q_exec($q);
    ?><tr> <td>Aceptar</td><td>rechazar</td> <?php
    for ($i = 0; $i < mysql_num_fields($r); $i++) {
        ?><td align="center"><?php echo mysql_field_name($r, $i) ?></td><?php
    }
    ?></tr><?php
    while ($f = mysql_fetch_assoc($r)) {
        ?><tr>
            <td align="center"><input type="radio" name="<?php echo $f['Correo']; ?>" value="1"></td>
            <td align="center"><input type="radio" name="<?php echo $f['Correo']; ?>" value="2"></td>
            <?php
        foreach ($f as $key => $value) {
            ?><td align="center"><?php echo $lista[$key] = $value; ?></td><?php
        }
        ?></tr><?php
    }

     ?>
    </table>
    <div class="button_box" align="center">
        <button type="submit" name="pending_user_button" value="none" class="button_hot principal">Enviar</button>
        <button type="reset" class="button_hot">Deshacer</button>
        <button type="button" class="button_hot secundary" onclick="window.location.href='main.php'">Regresar</button>
    </div>
</form>
<?php
$session_user = $_SESSION['user'];

if(isset($_POST["pending_user_button"])){
    if(sizeof($_POST) == 1){
        header("location: pending_users.php");
    };

    $temp1 = "";
    foreach ($_POST as $key => $value) {
        if($value == 1){
            $temp1 .= "user_user = '$key'"." OR ";
        }
    }
    $arg1 = substr($temp1, 0, strripos($temp1, "OR"));
    if($temp1 != ""){
        $q1 = "UPDATE users SET user_active = 1 WHERE $arg1";
        $r = q_log_exec($session_user, $q1);
    }
    $temp2_1 = "";
    $temp2_2 = "";
    foreach ($_POST as $key => $value) {
        if($value == 2){
            $temp2_1 .= "fk_user = (SELECT user_id FROM users WHERE user_user = '$key'
)"." OR ";
            $temp2_2 .= "user_user = '$key'"." OR ";
        }
    }
    $arg2_1 = substr($temp2_1, 0, strripos($temp2_1, "OR"));
    $arg2_2 = substr($temp2_2, 0, strripos($temp2_2, "OR"));
    if($temp2_1 != ""){
        $q2_2 = "DELETE FROM userdata WHERE $arg2_1";
        $r2_2 = q_exec($q2_2);
        $q2_1 = "DELETE FROM users WHERE $arg2_2";
        $r2_1 = q_log_exec($session_user, $q2_1);

    }
    ?>
    <script type="text/javascript">
        alert("Cambios realizados con éxito");
        window.location.href = "main.php";
    </script>
    <?php
}
require 'footer.php';
 ?>
