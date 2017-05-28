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
<script src="<?php echo PROJECT_HOST;?>js/make_invoices.js" charset="utf-8"></script>
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
                             <table class="table table-bordered" id="cabecera">
                                 <?php
                                 foreach ($invoices['head'] as $key => $value) {
                                     ?>
                                     <tr>
                                         <th><?php echo $key; ?></th>
                                         <td align="center"><?php if(is_numeric($value)) {echo number_format($value, 2, ',', '.');}else{echo $value;}?></td>
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
                             <table class="table table-bordered" id="resumen">
                                 <?php
                                 foreach ($invoices['summary'] as $key => $cat) {
                                     ?>
                                     <tr>
                                         <th colspan="2"><?php echo $key; ?></th>
                                     </tr>
                                     <?php
                                     foreach ($cat as $item => $value) {
                                        ?>
                                        <tr>
                                            <td><?php echo $item; ?></td>
                                            <td align="center"><?php if(is_numeric($value)) {echo number_format($value, 2, ',', '.');}else{echo $value;}?></td>
                                        </tr>
                                        <?php
                                     }
                                 }
                                  ?>
                             </table>
                         </div>
                     </div>
                 </div>
                 <div class="col-md-6">
                     <button type="button" name="button" class="btn btn-primary btn-block btn-lg" data-id="<?php echo $_SESSION['user_id']; ?>" data-lapse="<?php echo $invoices['head']['Gen Num']; ?>" onclick="seeInvoice(this);">Mostrar Recibo Propio</button>
                 </div>
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-md-12" align="center">
            <button type="button" name="button" class="btn btn-success btn-lg" onclick="saveInvoices('invoices');">Guardar</button>
            <button type="button" name="button"class="btn btn-danger btn-lg" onclick="discard('invoices');">Deshacer</button>
         </div>
     </div>
     <div class="row">
         <div class="col-md-3">

         </div>
         <div class="col-md-6" id="result" style="margin-top:20px;text-align:center;align:center;">

         </div>
     </div>
 </div>

<span id="invoices" data-value="<?php echo $invoices['head']['Gen Num']; ?>" hidden>
    <?php echo $invoices_js; ?>
</span>

 <?php
require ROOTDIR.'footer.php';
  ?>
