<?php
require '../datos.php';
session_start();
require ROOTDIR.'header.php';
require ROOTDIR.'menu.php';
require ROOTDIR.'core/engine.php';

$user = $_SESSION['user'];
$invoices = generate($user, $_GET);
$invoices_js = json_encode($invoices);
 ?>
<script src="<?php echo PROJECT_HOST;?>js/make_invoice.js" charset="utf-8"></script>
 <div id="page-wrapper">
     <div class="row">
         <div class="page-header">
             <h3>Generador de Recibos</h3>
         </div>
     </div>
     <div class="panel panel-default">
         <div class="panel-body">
             <div class="row">
                 <div class="col-md-6">
                     <div class="panel panel-default">
                         <div class="panel-heading">
                            <h3 class="panel-title">Cabecera</h3>
                         </div>
                         <div class="panel-body">
                             <table class="table table-bordered">
                                 <?php
                                 foreach ($invoices[0] as $key => $value) {
                                     ?>
                                     <tr>
                                         <th><?php echo $key; ?></th>
                                         <td><?php echo $value; ?></td>
                                     </tr>
                                     <?php
                                 }
                                  ?>

                             </table>
                         </div>
                     </div>
                 </div>
                 <div class="col-md-6">
                     <div class="panel panel-default">
                         <div class="panel-heading">
                            <h3 class="panel-title">Resumen</h3>
                         </div>
                         <div class="panel-body">
                             <table class="table table-bordered">
                                 <?php
                                 foreach ($invoices[1] as $key => $value) {
                                     ?>
                                     <tr>
                                         <th><?php echo $key; ?></th>
                                         <td><?php echo $value; ?></td>
                                     </tr>
                                     <?php
                                 }
                                  ?>
                             </table>
                         </div>
                     </div>
                 </div>
                 <div class="col-md-6">
                     <button type="button" name="button" class="btn btn-primary btn-block btn-lg" onclick="seeInvoice(this);">Mostrar Recibo Propio</button>
                 </div>
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-md-12" align="center">
            <button type="button" name="button" class="btn btn-success btn-lg" onclick="saveInvoices('invoices');">Guardar</button>
            <button type="button" name="button"class="btn btn-danger btn-lg" onclick="window.history.go(-1);">Deshacer</button>
         </div>
     </div>
     <div class="row">
         <div class="col-md-3">

         </div>
         <div class="col-md-6" id="result" style="margin-top:20px;text-align:center;align:center;">

         </div>
     </div>
 </div>
<div class="overlay" id="example" hidden>
    <div class="overlay-content" style="margin-top:100px">
        <img src="<?php echo PROJECT_HOST;?>static/recibo.png" alt="" height="560px" width="auto">
        <div class="but">
            <a href="#" onclick="hideModal('example')">X</a>
        </div>
    </div>
</div>
<span id="invoices" data-value="<?php echo $invoices[0]['Gen Num']; ?>" hidden>
    <?php print_r($invoices_js); ?>
</span>

 <?php
require ROOTDIR.'footer.php';
  ?>
