<?php
require '../datos.php';
//Tabla dinámica
session_start();
require ROOTDIR.'header.php';
require ROOTDIR.'menu.php';
?>
<div id="page-wrapper">


	<h2 align="center">Registro de Usuarios</h2>
	<table width="100%" class="table table-striped table-bordered table-hover">

	<?php
	require ROOTDIR.'server.php';
	connect();
	//Se seleccionan los datos de todos los usuarios en varias tablas
	$q = "SELECT udata_name AS 'Nombre',
			udata_surname AS 'Apellido',
	        udata_ci AS 'C.I.',
	        A17_number AS 'Apartamento',
			user_user AS 'Correo',
			CASE user_type
				WHEN 1 THEN 'Administrador'
				WHEN 2 THEN 'Usuario'
				ELSE 'Indeterminado'
			END AS 'Tipo de Usuario'
	    FROM users, userdata, A17 WHERE udata_user_fk = user_id AND udata_number_fk = A17_id AND user_active = 1";
	$r = q_exec($q);
	?>
	<tr class="dynTableHeader"> <td></td> <?php
		for ($i = 0; $i < mysql_num_fields($r); $i++) {
		    ?><td align="center"><?php echo mysql_field_name($r, $i) ?></td>
			<?php
	}
	?>
	</tr>

	<?php
	//Se construye el encabezado de la tabla
	while ($row = mysql_fetch_assoc($r)) {
	    ?>
		<tr>
	        <td align="center"><input type="checkbox" name="" value=""></td>
	        <?php
	    foreach ($row as $key => $value) {
			//Se construyen las filas de la tabla
	        ?><td align="center"><?php echo $lista[$key] = $value; ?></td><?php
	    }
	    ?></tr>
		<?php
	}

	 ?>
	</table>
	<div class="button_box" align="center">
	    <button type="button" name="button" class="button_hot secundary" onclick="history.go(-1)">Regresar</button>
	</div>
</div>
<?php
require ROOTDIR.'footer.php';
 ?>
