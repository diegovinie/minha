<?php
session_start();
require '../datos.php';
require ROOTDIR.'header.php';
require ROOTDIR.'menu.php';
$user = $_SESSION['user'];
 ?>
<script type="text/javascript">
    window.onload = function(){
		host = "../core/async_user_payments.php?fun=pays&user=<?php echo $user; ?>&arg=";
		var id1 = "pagos";
		getDataAjax(host, id1, function(res){
			setTable(id1, res, function(){
				tablePager(id1, function(){
					$('#'+id1).find('tbody').children().each(function(){
						$(this).attr('onclick', 'showInfo(this)')
					})
				})
			})
		})
		var id2 = "pagos_en_revision"
		getDataAjax(host, id2, function(res){
			setTable(id2, res, function(){
				tablePager(id2, function(){
					$('#'+id2).find('tbody').children().each(function(){
						$(this).attr('onclick', 'showInfo(this)');
					})
				})
			})
		})
        var id3 = "devueltos"
        getDataAjax(host, id2, function(res){
            setTable(id2, res, function(){
                tablePager(id2, function(){
                    $('#'+id2).find('tbody').children().each(function(){
                        $(this).attr('onclick', 'showInfo(this)');
                    })
                })
            })
        })
    	function radioYes(self){
    		console.log('yes')
    	};
    	function radioNo(self){
    		console.log('no')
    	};
    	function showInfo(self){
    	};
    }
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Pagos</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Historial de Pagos</h4>
                </div>
                <div class="panel-body" id="pagos">
                    <!-- async data -->
                </div>
                <div class="panel-footer">

                </div>
                <div class="panel-footer col-lg-12" style="margin-bottom: 60px;">
                    <button type="button" name="agregar_proveedor" class="btn btn-primary btn-lg" style="float: right;" onclick="window.location.href = 'add_payment.php'">Registrar Nuevo Pago</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Pagos En Revisión</h4>
                </div>
                <div class="panel-body" id="pagos_en_revision">
                    <!-- async data -->
                </div>
                <div class="panel-footer">

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Pagos Devueltos</h4>
                </div>
                <div class="panel-body" id="devueltos">
                    <!-- async data -->
                </div>
                <div class="panel-footer">

                </div>
            </div>
        </div>
    </div>
</div>

<?php

require '../footer.php';
 ?>
