<?php
session_start();
require '../header.php';
require '../menu.php';
require '../server.php';
connect();
$q1 = "SELECT bil_id, bil_date, bil_desc, bil_rif, up_alias, lap_name, bil_amount, bil_iva, bil_total, bkb_name, bil_notes FROM bills, usual_providers, lapses, backup_bills WHERE up_id = bil_type_fk AND lap_id = bil_lapse_fk AND bkb_id = bil_bk_fk ORDER BY bil_id DESC";
$r1 = q_exec($q1);
//$r1_ar = query_to_array($r1);
$q2 = "SELECT bil_id, bil_date AS 'fecha', up_alias, bil_total FROM bills, usual_providers WHERE up_id = bil_type_fk ORDER BY bil_id DESC";
$r2 = q_exec($q2);

//print_r($r1_ar);
$col = ['bil_id', 'bil_date', 'up_alias', 'bil_amount'];

 ?>
 <link rel="stylesheet" href="/minha/statics/modal.css">
 <script src="/minha/js/ajax.js" charset="utf-8"></script>
 <script src="/minha/js/modal.js" charset="utf-8"></script>
 <script src="/minha/js/unpacking_ajax.js" charset="utf-8"></script>
 <script src="/minha/js/buttons.js" charset="utf-8"></script>
 <script src="/minha/js/engine.js" charset="utf-8"></script>
<script type="text/javascript">
    window.onload = function(){
        var see = ['bil_id', 'bil_date', 'up_alias', 'bil_amount'];
        for(v in see){
            var c = document.getElementsByClassName(see[v]);
            for(i = 0; i < c.length; i++)
                c.item(i).style.display = 'table-cell';
        }
    }

    function info(a){
        var lista = {
        id :    a.getElementsByClassName('bil_id').item(0).innerHTML,
        date :  a.getElementsByClassName('bil_date').item(0).innerHTML,
        desc :  a.getElementsByClassName('bil_desc').item(0).innerHTML,
        rif :   a.getElementsByClassName('bil_rif').item(0).innerHTML,
        alias : a.getElementsByClassName('up_alias').item(0).innerHTML,
        lapse : a.getElementsByClassName('lap_name').item(0).innerHTML
        }
        var b = "<ul align='left'>";
        for (i in lista) {
            b += "<li>" +i + ": " + lista[i] + "</li>\n";
        }
        b += "</ul>"
        ventana("Información del Gasto", b);
    }
</script>

 <h2>Gastos</h2>

 <h3>Últimos gastos registrados</h3>

<table class="dynTable" align="center">
    <tr class="dynTableHeader">
        <?php
       for ($i = 0; $i < mysql_num_fields($r1); $i++) {
           ?><td align="center" class=<?php echo mysql_field_name($r1, $i) ?> style="display:none"><?php echo mysql_field_name($r1, $i)?></td>
           <?php
       } ?>
    </tr>
        <?php
            while($row = mysql_fetch_assoc($r1)){
                ?><tr id=<?php echo $row['bil_id'] ?> class="row" onmouseover="this.style.color='gray'" onmouseout="this.style.color='black'" onclick="info(this)">
                    <?php
                foreach ($row as $key => $value) {
                    ?><td class=<?php echo $key ?> style="display:none"><?php echo $value ; ?> </td>
                    <?php
                }
                ?></tr>
                <?php
            }
         ?>

</table>

 <h3>Recibos generados</h3>
 <select class="" name="">


 <?php
 $files = array_diff(scandir(ROOTDIR.'/files'), array('..', '.'));

 print_r($files);

 foreach ($files as $key => $value) {
     ?> <option value=""><?php echo $value ?></option> <?php
 }
  ?>
 </select>
<div class="">
    <button type="submit" name="generar" onclick="makeWindow()">Generar Recibos</button>
</div>

 <?php
require '../footer.php';
  ?>
