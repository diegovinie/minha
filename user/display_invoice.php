<?php
// Modelo: core/pdf_invoice.php

session_start();
require '../datos.php';
require ROOTDIR.'header.php';
require ROOTDIR.'menu.php';
require ROOTDIR.'server.php';
$bui = $_SESSION['bui'];

$dir = ROOTDIR."files/invoices/$bui";
$gestor_dir = opendir($dir);
while(false !== ($nombre_fichero = readdir($gestor_dir))){
    if($nombre_fichero != '.' && $nombre_fichero != '..'){
        $a = substr($nombre_fichero, 0, strrpos($nombre_fichero, "."));
        $b = substr($a, 4, strlen($a));
        $month = substr($b, -2, strlen($b));
        $year = substr($b, 0, 4);
        $ficheros[$month.'/'.$year] = $b;
    }
}

 ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h2 class="page-header">Mostrar Recibo</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Seleccione:</h3>
                </div>
                <div class="panel-body">
                    <form class="" action="../core/pdf_invoice.php" method="get" target="_blank">
                        <div class="form-group">
                            <label for="">Periodo: </label>
                            <select class="form-control" name="lapse" id='date'>
                                <?php
                                foreach ($ficheros as $key => $value) {
                                    ?>
                                <option value="<?php echo $value; ?>"><?php echo $key; ?></option>
                                <?php
                                }
                                 ?>
                            </select>
                        </div>
                        <div class="" align="center">
                            <button class="btn btn-success" type="submit" name="button" class="button_hot principal">Mostrar</button>
                            <button class="btn btn-danger" type="button" name="button" class="button_hot secundary" onclick="history.go(-1)">Regresar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
require '../footer.php';
 ?>
