<?php
//Area de entrada después de la autenticación.
// Controlador: js/main.js
// Modelo: core/async_main.php

require_once 'datos.php';
session_start();
if(isset($_SESSION['user']) && $_SESSION['status'] == 'active'){
    require 'header.php';
    require 'menu.php';
?>
  <div id="page-wrapper">
      <div class="row">
          <div class="col-lg-12">
              <h1 class="page-header">Inicio</h1>
          </div>
          <!-- /.col-lg-12 -->
      </div>
      <!-- /.row -->
      <?php
        if($_SESSION['type'] == 1){
            ?>
           <!--<div class="row">
               <div class="col-lg-3 col-md-6">
                   <div class="panel panel-primary">
                       <div class="panel-heading">
                           <div class="row">
                               <div class="col-xs-3">
                                   <i class="fa fa-comments fa-5x"></i>

                               </div>
                               <div class="col-xs-9 text-right">
                                   <div class="huge">4</div>
                                   <div>Nuenos Mensajes</div>
                               </div>
                           </div>
                       </div>
                       <a href="#">
                           <div class="panel-footer">
                               <span class="pull-left">Ver detalles</span>
                               <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                               <div class="clearfix"></div>
                           </div>
                       </a>
                   </div>

               </div>
               <div class="col-lg-3 col-md-6">
                   <div class="panel panel-green">
                       <div class="panel-heading">
                           <div class="row">
                               <div class="col-xs-3">
                                   <i class="fa fa-tasks fa-5x"></i>
                               </div>
                               <div class="col-xs-9 text-right">
                                   <div class="huge">26</div>
                                   <div>Pagos Pendientes</div>
                               </div>

                           </div>
                       </div>
                       <a href="#">
                           <div class="panel-footer">
                               <span class="pull-left">Ver detalles</span>
                               <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                               <div class="clearfix"></div>
                           </div>
                       </a>
                   </div>

               </div>
               <div class="col-lg-3 col-md-6">
                   <div class="panel panel-yellow">
                       <div class="panel-heading">
                           <div class="row">
                               <div class="col-xs-3">
                                   <i class="fa fa-tasks fa-5x"></i>
                               </div>
                               <div class="col-xs-9 text-right">
                                   <div class="huge">8</div>
                                   <div>Solicitudes</div>
                               </div>
                           </div>
                       </div>
                       <a href="#">
                           <div class="panel-footer">
                               <span class="pull-left">Ver detalles</span>
                               <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                               <div class="clearfix"></div>
                           </div>
                       </a>
                   </div>
               </div>
               <div class="col-lg-3 col-md-6">
                   <div class="panel panel-red">
                       <div class="panel-heading">
                           <div class="row">
                               <div class="col-xs-3">
                                   <i class="fa fa-support fa-5x"></i>
                               </div>
                               <div class="col-xs-9 text-right">
                                   <div class="huge">0</div>
                                   <div>Reclamos</div>
                               </div>
                           </div>
                       </div>
                       <a href="#">
                           <div class="panel-footer">
                               <span class="pull-left">Ver detalles</span>
                               <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                               <div class="clearfix"></div>
                           </div>
                       </a>
                   </div>
               </div>
           </div>-->
           <!-- /.row -->
          <?php

        }
        ?>
      <div class="row">
      <div class="col-lg-4">

      </div>
      <!-- /.col-lg-8 -->
      <div class="col-lg-4">
          <div class="panel panel-info">
              <div class="panel-heading">
                  <h3 class="panel-title">Enviar Correo:</h3>
              </div>
              <div class="panel-body">
                  <a href="<?php echo PROJECT_HOST;?>testing/email.php">enviar</a>
              </div>
          </div>
      </div>
      <div class="col-lg-4">
          <div class="panel panel-warning">
              <div class="panel-heading">
                  <h3 class="panel-title">Balance a la fecha:</h3>
              </div>
              <div class="panel-body">
                  <span id="balance"></span>
              </div>
          </div>
      </div>
      <!-- /.col-lg-4 -->
  </div>
      <!-- /.row -->
  </div>
<script src="js/main.js" charset="utf-8"></script>

<?php
require 'footer.php';
}else{
    echo "Área restringida.";
    ?>
    <script type="text/javascript">
        setTimeout(function(){
            window.location.href = "<?php echo PROJECT_HOST; ?>login.php";
        }, 2000);
    </script>
    <?php
}
if(isset($time_ini)) rec_exec_time($time_ini, __FILE__, __LINE__);
  ?>
