<?php
require_once '../datos.php';
// Construye tabla (thead. tbody) a partir de resultados mysql
function tabla1($r, $id){
    ?>
    <table width="100%" class="table table-striped table-bordered table-hover" id="t_<?php echo $id ?>">
        <thead>
            <tr>
                <?php
                for ($i = 0; $i < mysql_num_fields($r); $i++) {
                    ?><th align="center"><?php echo mysql_field_name($r, $i) ?></th>
                    <?php
            } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysql_fetch_assoc($r)) {
            ?>
            <tr>
            <?php
            foreach ($row as $key => $value) {
                //Se construyen las filas de la tabla
                ?><td name="<?php echo $key ?>" data-type="<?php echo $key; ?>" data-value="<?php echo $value ?>" align="center"><?php echo $lista[$key] = $value; ?></td><?php
            }
            ?>
            </tr>
            <?php
            }
            ?>
        </tbody>
     </table>
    <?php
}

// Grupo de funciones para construir tablas a partir de resultados mysql
function table_open($id){
    ?>
    <table width="100%" class="table table-striped" id="t_<?php echo $id ?>">
    <?php
}

function table_close(){
    ?>
    </table>
    <?php
}

function table_head($r){
    ?>
    <thead>
        <tr>
            <?php
            for ($i = 0; $i < mysql_num_fields($r); $i++) {
                ?><th style="text-align:center;"><?php echo mysql_field_name($r, $i) ?></th>
                <?php
        } ?>
        </tr>
    </thead>
    <?php
}

function table_tbody($r){
    ?>
        <tbody>
            <?php
            while ($row = mysql_fetch_assoc($r)) {
            ?>
            <tr>
            <?php
            foreach ($row as $key => $value) {
                //Se construyen las filas de la tabla
                ?><td name="<?php echo $key ?>" data-type="<?php echo $key; ?>" data-value="<?php echo $value ?>" align="center"><?php echo $lista[$key] = $value; ?></td><?php
            }
            ?>
            </tr>
            <?php
            }
            ?>
        </tbody>
    <?php
}

function table_tfoot($r){
    ?>
        <tfoot>
            <?php
            while ($row = mysql_fetch_assoc($r)) {
            ?>
            <tr>
            <?php
                foreach ($row as $key => $value) {
                    //Se construyen las filas de la tabla
                    ?><th name="<?php echo $key ?>" data-type="<?php echo $key; ?>" data-value="<?php echo $value ?>"><?php echo $lista[$key] = $value; ?></th><?php
                }
            ?>
            </tr>
            <?php
            }
            ?>
        </tfoot>
    <?php
}
/////////////

function table_body_only($r, $id){
    ?>
    <table width="100%" class="table table-striped" id="t_<?php echo $id ?>">
        <tr>
            <?php
            for ($i = 0; $i < mysql_num_fields($r); $i++) {
                ?><th style="text-align:center;"><?php echo mysql_field_name($r, $i) ?></th>
                <?php
        } ?>
        </tr>
        <?php
        while ($row = mysql_fetch_assoc($r)) {
        ?>
        <tr>
        <?php
        foreach ($row as $key => $value) {
            //Se construyen las filas de la tabla
            ?><td name="<?php echo $key ?>" data-type="<?php echo $key; ?>" data-value="<?php echo $value ?>" align="center"><?php echo $lista[$key] = $value; ?></td><?php
        }
        ?>
        </tr>
        <?php
        }
    ?>
    </table>
    <?php
    }

 function tabla_radio($r, $id){
     ?>
     <table width="100%" class="table table-bordered table-hover" id="t_<?php echo $id; ?>">
         <thead>
             <tr>
                 <th>Aceptar</th><th>Rechazar</th> <?php
             for ($i = 0; $i < mysql_num_fields($r); $i++) {
                 ?><th align="center"><?php echo mysql_field_name($r, $i) ?></th><?php
             }
             ?>
             </tr>
         </thead>
         <tbody>
             <?php while($row = mysql_fetch_assoc($r)){
                 ?>
             <tr>
                 <td align="center"><input type="radio" name="<?php echo $row['id']; ?>" value="1" onclick="markSuccess(this)"></td>
                 <td align="center"><input type="radio" name="<?php echo $row['id']; ?>" value="2" onclick="explain(this)"></td>

                 <?php foreach ($row as $key => $value) {
                     ?><td align="center" data-type="<?php echo $key; ?>" data-value="<?php echo $value; ?>"><?php echo $value ?></td>
                     <?php
                 }
                 ?>
             </tr>
             <?php
         } ?>
         </tbody>
     </table>
     <?php
 }

function invoice_header($invoices){
    ?>
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
    <?php
}

function invoice_summary($invoices){
    ?>
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
    <?php
}
 ?>
