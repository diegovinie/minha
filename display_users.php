<?php
session_start();
require 'header.php';
require 'menu.php';
?>
<h1>Registro de Usuarios</h1>
<table align="center" border="1">

<?php
require 'server.php';
connect();

$q = "SELECT udata_name AS 'Nombre',
		udata_surname AS 'Apellido',
        udata_ci AS 'C.I.',
        udata_number AS 'Apartamento',
		user_user AS 'Correo',
        user_type AS 'Tipo de Usuario'
    FROM users, userdata WHERE fk_user = user_id AND user_active = 1";
$r = q_exec($q);
?><tr> <td></td> <?php
for ($i = 0; $i < mysql_num_fields($r); $i++) {
    ?><td align="center"><?php echo mysql_field_name($r, $i) ?></td><?php
}
?></tr><?php
while ($f = mysql_fetch_assoc($r)) {
    ?><tr>
        <td align="center"><input type="checkbox" name="" value=""></td>
        <?php
    foreach ($f as $key => $value) {
        ?><td align="center"><?php echo $lista[$key] = $value; ?></td><?php
    }
    ?></tr><?php
}

 ?>
</table>
<div class="">
    <button type="button" name="button" onclick="window.location.href='main.php'">Regresar</button>
</div>
<?php
require 'footer.php';
 ?>
