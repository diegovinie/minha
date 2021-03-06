<?php
// Controlador: js/main.js
// Modelo: core/async_main.php

require_once 'datos.php';
if(!isset($_SESSION['name'])){
	header("Location: ${HTTP_HOST}login.php");
    exit;
}
?>
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
		<div class="navbar-header">
			<button  type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="main.php"><?php echo NAME ." versión: " .VERSION; ?></a>
		</div>
		<!-- /.navbar-header -->

		<ul class="nav navbar-top-links navbar-right">
			<li class="dropdown">
				<!--<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					<i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
				</a>
				<ul class="dropdown-menu dropdown-messages">
					<li>
						<a href="#">
							<div>
								<strong>Alerta Sistema</strong>
								<span class="pull-right text-muted">
									<em>Ayer</em>
								</span>
							</div>
							<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="#">
							<div>
								<strong>Jorge Pérez</strong>
								<span class="pull-right text-muted">
									<em>Hace 2 días</em>
								</span>
							</div>
							<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="#">
							<div>
								<strong>Carmen Alvarez</strong>
								<span class="pull-right text-muted">
									<em>Hace una semana</em>
								</span>
							</div>
							<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a class="text-center" href="#">
							<strong>Todos los Mensajes</strong>
							<i class="fa fa-angle-right"></i>
						</a>
					</li>
				</ul>-->
				<!-- /.dropdown-messages -->
			</li>
			<!-- /.dropdown -->
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><?php
					echo "Bienvenido, ".$_SESSION['name'];
				?>
					<i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
				</a>
				<ul class="dropdown-menu dropdown-user">
					<li><a href="<?php echo PROJECT_HOST;?>user/profile.php"><i class="fa fa-user fa-fw"></i> Perfil Usuario</a>
					</li>
					<!--<li><a href="#"><i class="fa fa-gear fa-fw"></i> Ajustes</a>
					</li>-->
					<li class="divider"></li>
					<li><a href="<?php echo PROJECT_HOST;?>logout.php"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesión</a>
					</li>
				</ul>
				<!-- /.dropdown-user -->
			</li>
			<!-- /.dropdown -->
		</ul>
		<!-- /.navbar-top-links -->

		<div class="navbar-default sidebar" role="navigation">
			<div class="sidebar-nav navbar-collapse">
				<ul class="nav" id="side-menu">
					<li class="sidebar-search">
						<div class="input-group custom-search-form">
							<!--<input type="text" class="form-control" placeholder="Buscar...">
							<span class="input-group-btn">
							<button class="btn btn-default" type="button">
								<i class="fa fa-search"></i>
							</button>
						</span>-->
						</div>
						<!-- /input-group -->
					</li>
					<li>
						<a href="<?php echo PROJECT_HOST;?>main.php"><i class="fa fa-dashboard fa-fw"></i> Inicio</a>
					</li>
					<li>
						<a class="text-muted" href="javascript:void(0);">Información<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li><a class="text-muted" href="javascript:void(0);">Normas</a></li>
							<li><a class="text-muted" href="javascript:void(0);">Seguimiento de Casos Especiales</a></li>
						</ul>
					</li>
					<li>
						<a href="">Pagos y Recibos<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li><a href="<?php echo PROJECT_HOST;?>user/user_payments.php">Pagos</a></li>
							<li><a href="<?php echo PROJECT_HOST;?>user/display_invoice.php">Recibos de Condominio</a></li>
						</ul>
					</li>
					<li>
						<a class="text-muted" href="javascript:void(0);">Solicitudes <span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li><a class="text-muted" href="javascript:void(0);">Constancias</a></li>
							<li><a class="text-muted" href="javascript:void(0);">Llaves</a></li>
						</ul>
					</li>

					<?php
					if(session_status() == 2){
						if($_SESSION['type'] == 1){
					?>
					<li><a href="">Administracion<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li><a href="<?php echo PROJECT_HOST;?>admin/payments.php">Pagos y Recibos<span class="fa arrow"></span></a>
								<ul class="nav nav-third-level">
									<li><a href="<?php echo PROJECT_HOST;?>admin/payments.php">Pagos</a></li>
									<li><a href="<?php echo PROJECT_HOST;?>admin/invoices.php">Recibos</a></li>
								</ul>
							</li>
							<li><a href="<?php echo PROJECT_HOST;?>admin/bills.php">Gastos y Proveedores</a></li>
							<li><a href="<?php echo PROJECT_HOST;?>admin/balance.php">Estados Financieros</a></li>
							<li><a class="text-muted" href="javascript:void(0);">Casos Especiales</a></li>
							<li><a href="<?php echo PROJECT_HOST;?>admin/display_users.php">Usuarios</a></li>
							<li><a class="text-muted" href="javascript:void(0);">Solicitudes</a></li>
						</ul>
					</li>
					<?php
						}
					}
					?>
					<li><a class="text-muted" href="javascript:void(0);">Medios <span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li><a class="text-muted" href="javascript:void(0);">Publicar Nota</a></li>
							<li><a class="text-muted" href="javascript:void(0);">Encuestas</a></li>
							<li><a class="text-muted" href="javascript:void(0);">Mensajes</a></li>
						</ul>
					</li>
					<li><a class="text-muted" href="javascript:void(0);">Ayuda</a></li>
				</ul>
			</div>

		</div>
	</nav>
</header>
<main>
