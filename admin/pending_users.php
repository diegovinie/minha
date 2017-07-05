<?php
require '../datos.php';
//Formulario con tabla dinámica
//Estructuras de control para crear consultas
session_start();
require ROOTDIR.'header.php';
require ROOTDIR.'menu.php';
?>
<div id="page-wrapper">
    <h2 align="center">Usuarios Pendiente por Activación</h2>
    <form class="" action="admin/pending_users.php" method="post">
        <table width="100%" class="table table-striped table-bordered table-hover">
        <?php
        require ROOTDIR.'server.php';
        connect();
        //Se seleccionan los datos para construir la tabla de usuarios pendientes
        $q = "SELECT udata_name AS 'Nombre',
        		udata_surname AS 'Apellido',
                udata_ci AS 'C.I.',
                A17_number AS 'Apartamento',
        		user_user AS 'Correo'
            FROM users, userdata, A17 WHERE udata_user_fk = user_id AND udata_number_fk = A17_id AND user_active = 0";
        $r = q_exec($q);
        ?><tr class="dynTableHeader"> <td>Aceptar</td><td>rechazar</td> <?php
        for ($i = 0; $i < mysql_num_fields($r); $i++) {
            ?><td align="center"><?php echo mysql_field_name($r, $i) ?></td><?php
        }
        ?></tr><?php
        while ($row = mysql_fetch_assoc($r)) {
            //Los botones para selecionar los usuarios a aceptar(1) o borrar(2)
            ?><tr>
                <td align="center"><input type="radio" name="<?php echo $row['Correo']; ?>" value="1"></td>
                <td align="center"><input type="radio" name="<?php echo $row['Correo']; ?>" value="2"></td>
                <?php
                //se construyen las filas
            foreach ($row as $key => $value) {
                ?><td align="center"><?php echo $tr[$key] = $value; ?></td><?php
            }
            ?></tr><?php
        }

         ?>
        </table>
        <div class="button_box" align="center">
            <button type="submit" name="pending_user_button" value="none" class="button_hot principal">Enviar</button>
            <button type="reset" class="button_hot">Deshacer</button>
            <button type="button" class="button_hot secundary" onclick="history.go(-1)">Regresar</button>
        </div>
    </form>
</div>
<?php
$session_user = $_SESSION['user'];
//Se verifica si el formulario fue enviado
if(isset($_POST["pending_user_button"])){
    //Si fue enviado vacío
    if(sizeof($_POST) == 1){
        header("location: pending_users.php");
    };
    //Cadena constructora de la consulta
    $temp1 = "";
    //Se revisa para cada usario si fue aprobado
    foreach ($_POST as $key => $value) {
        if($value == 1){
            $temp1 .= "user_user = '$key'"." OR ";
        }
    }
    //Se limpia el argumento
    $arg1 = substr($temp1, 0, strripos($temp1, "OR"));
    //Si hay usuarios para agregar ejecuta las consultas
    if($temp1 != ""){
        $q1 = "UPDATE users SET user_active = 1 WHERE $arg1";
        $r = q_log_exec($session_user, $q1);
    }
    //Cadenas constructuras de consultas
    $temp2_1 = "";
    $temp2_2 = "";
    //Se revisa para cada usuario si fue eliminado
    foreach ($_POST as $key => $value) {
        if($value == 2){
            $temp2_1 .= "fk_user = (SELECT user_id FROM users WHERE user_user = '$key'
)"." OR ";
            $temp2_2 .= "user_user = '$key'"." OR ";
        }
    }
    //Se limpian los argumentos
    $arg2_1 = substr($temp2_1, 0, strripos($temp2_1, "OR"));
    $arg2_2 = substr($temp2_2, 0, strripos($temp2_2, "OR"));
    //Si hay usuarios a eliminar ejecuta las consultas
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
require ROOTDIR.'footer.php';
 ?>
