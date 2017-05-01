<?php
session_start();
require '../header.php';
require '../menu.php';
require '../server.php';

connect();

$q1 = "SELECT sum(A17_balance) FROM A17";
$r1 = q_exec($q1);

$q2 = "SELECT sum(cha_amount) FROM charges";
$r2 = q_exec($q2);

$r1_ar = mysql_fetch_array($r1);
//print_r($r1_ar);
$r2_ar = mysql_fetch_assoc($r2);
//print_r($r2_ar);

$q3 = "SELECT A17_id, A17_number, A17_balance FROM A17";
$r3 = q_exec($q3);

$q4 = "SELECT A17_number, cha_amount, cha_timestamp FROM A17, charges WHERE cha_fk_number = A17_id AND cha_amount < 0";
$r4 = q_exec($q4);
//  $r4_ar = query_to_array($r4);
//print_r($r4_ar);


 ?>
 <link rel="stylesheet" href="/minha/statics/modal.css">
 <script src="/minha/js/modal.js" charset="utf-8"></script>
 <script src="/minha/js/ajax.js" charset="utf-8"></script>
 <script src="/minha/js/unpacking_ajax.js" charset="utf-8"></script>
 <script type="text/javascript">
    window.onload = function(){
        var a = document.getElementsByClassName('A17_id');
        for(var i = 0; i < a.length; i++){
            a.item(i).style.display = 'none';
        }
        rows = document.getElementById('aptos').querySelectorAll('.row');
        vis = 10;
        for(var i = vis; i < rows.length; i++ ){
            rows.item(i).style.display = 'none';
        }

    }

    function move(arg){
        vis += (vis < 10 - arg || vis > rows.length - arg)? 0 : arg;
        for(var i = 0; i < rows.length; i++){
            if((i > vis-Math.abs(arg)-1) && (i <= vis-1)){
                rows.item(i).style.display = 'table-row';
            }else {
                rows.item(i).style.display = 'none';
            }
        }
    }

    function showApt(self){
            var url = "/minha/core/query.php";
            var arg = "?fun=show_apt&number=";
            var n = self.getElementsByClassName('A17_id').item(0).innerHTML;
            AjaxPromete("/minha/core/query.php?fun=show_apt&number=" + n)
                .then(function(res2){return showUl(res2)})
                .then(function(res3){ventana('Información Apartamento', res3)})
                .then(function(res4){addButtonUsers(n)})
    }
 </script>
<div class=""  align="center">
     <table class="dynTable" align="center">
         <tr>
             <td>Balance General: </td><td><?php echo $r1_ar[0] ?></td>
         </tr>
     </table>

    <h2 align="center">Balance por apartamento</h2>
    <label for="selector" align="center">Ordenar por:</label>
    <select class="" name="selector" align="center">
        <option value="">Ascendente</option>
        <option value="">Descendente</option>
        <option value="">Mayor Deuda</option>
        <option value="">Menor Deuda</option>
    </select>

    <div class="" id="aptos">
    <table class="dynTable" align="center">
        <tr class="dynTableHeader">
            <?php
            for ($i = 0; $i < mysql_num_fields($r3); $i++) {
                ?><td align="center" class="<?php echo mysql_field_name($r3, $i) ?>"><?php echo mysql_field_name($r3, $i) ?></td><?php
            }
     ?>
        </tr>
        <?php while($row = mysql_fetch_assoc($r3)){
            ?>
            <tr id=<?php echo $row['A17_id']?> class="row" onclick="showApt(this)">
                <?php
                foreach ($row as $key => $value) {
                    ?><td class=<?php echo $key ?>><?php echo $value ?></td>
                <?php
            } ?>
        </tr>
        <?php
        } ?>
    </table>

        <button type="button" name="anterior" id="anterior" onclick="move(-10)">anterior</button>
        <button type="button" name="siguiente" id="siguiente" onclick="move(10)">siguiente</button>
    </div>

    <h2>Últimos Pagos</h2>
    <table class="dynTable">
        <?php while($row = mysql_fetch_assoc($r4)){
            ?><tr>
                <?php foreach ($row as $key => $value) {
                    ?><td><?php echo $value ?></td>
                    <?php
                } ?>
            </tr> <?php
        }
         ?>
    </table>
</div>
<?php
require '../footer.php';
 ?>
