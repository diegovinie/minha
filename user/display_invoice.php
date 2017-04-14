<?php
session_start();
require '../header.php';
require '../menu.php';
require '../server.php';

connect();

$qlapse = "SELECT lap_id, lap_name FROM lapses";
$rlapse = q_exec($qlapse);

 ?>
<h2>Mostrar Recibo</h2>
<form class="" action="display_invoice.php" method="post">
    <table>
         <tr>
             <td>Periodo: </td>
             <td><select class="" name="lapse" id='date'>
                 <?php
                 while($a = mysql_fetch_array($rlapse)){
                     ?>
                     <option value=<?php echo $a[0]; ?>><?php echo $a[1]; ?></option>
                     <?php
                 }
                  ?>
             </select></td>
         </tr>


    </table>
    <div class="button_box" align="center">
        <button type="submit" name="button" class="button_hot principal">Enviar</button>
        <button type="button" name="button" class="button_hot secundary" onclick="history.go(-1)">Regresar</button>
    </div>
</form>
 <?php

$session_user = $_SESSION['user'];
extract($_POST);
if(isset($button)){
    $q1 = "SELECT udata_name, udata_surname, udata_ci, udata_number_fk, A17_number FROM users, userdata, A17 WHERE user_user = '$session_user' AND udata_user_fk = user_id AND A17_id = udata_number_fk";
    $r1 = q_exec($q1);

    $q2 = "SELECT * FROM lapses WHERE lap_id = '$lapse'";
    $r2 = q_exec($q2);

    $a1 = ArrayToJson($r1);
    $a2 = ArrayToJson($r2);

    echo "<br>";
    echo "Nombre: ". $a1[0]['udata_name'].' '.$a1[0]['udata_surname']. "<br>";
    echo "C.I.: ". $a1[0]['udata_ci']. "<br>";
    echo "Apartamento: ". $a1[0]['A17_number']. "<br>";
    echo "Periodo facturado: ". $a2[0]['lap_name']. "<br>";

    $file = fopen(ROOTDIR.'files/fact-'.$a2[0]['lap_year'].'-'.$a2[0]['lap_month'].'.json', 'r');
    $b = fgets($file);
    $c = json_decode($b);
    $d = $c[1]->{'10F'};

    $porcentaje = 0.0;
    $total = 0.0;
    foreach ($d as $key => $v) {
        $porcentaje += $d->$key->{'porcentaje'};

    }
    $porcentaje = number_format($porcentaje, 2, ',','.');
            echo "<br>";
    foreach ($d as $key => $v) {
        $total += $d->$key->{'total'};
    }
    $total = number_format($total, 2, ',','.');
    ?>
    <table border="1">
        <?php foreach ($d as $key => $value): ?>
            <tr>
                <?php foreach ($d->$key as $k => $v): ?>
                    <td><?php print_r($v); ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Total Apartamento: <?php echo $porcentaje; ?></td>
                <td>Total General: <?php echo $total; ?></td>
            </tr>
    </table>


    <?php
}


require '../footer.php';
  ?>
