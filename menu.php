	<ul class="nav">
		<li><a href="">Pagos y Recibos</a>
            <ul>
                <li><a href="#">Registrar Pago</a></li>
                <li><a href="#">Pagar con Banco de Venezuela</a></li>
                <li><a href="">Recibos de Condominio</a></li>
                <li><a href="#">Historial de Pagos</a></li>
            </ul>
        </li>
		<?php
		if(session_status() == 2){
			if($_SESSION['type'] == 1){
		?>
		<li><a href="">Administracion</a>
            <ul>
                <li><a href="/minha/admin/add_bill.php">Registrar Gasto</a></li>
                <li><a href="#">Informe Ingresos</a></li>
                <li><a href="#">Informe de Egresos</a></li>
				<li><a href="#">Usuarios</a>
					<ul>
                        <li><a href="/minha/add_user.php">Añadir Usuarios</a></li>
                        <li><a href="/minha/display_users.php">Ver Usuarios</a></li>
                        <li><a href="/minha/pending_users.php">Solicitudes Pendientes</a></li>
                    </ul>
				</li>
            </ul>
        </li>
		<?php
			}
		}
		?>
		<li><a href="#">Blog</a></li>
		<li><a href="#">Cambio de Clave</a></li>
        <li><a href="/minha/login.php">Salir</a></li>
	</ul>
</header>
<main>
<br/>
<?php
echo "<div align='right' class='welcome'>Bienvenido, ".$_SESSION['name']."</div>";
?>
