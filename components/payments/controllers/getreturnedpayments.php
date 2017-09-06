<?php
/* components/payments/controllers/getreturnedpayments.php
 *
 */

defined('_EXE') or die('Acceso restringido');

$edf = (string)$_SESSION['edf'];
$aptid = (int)$_SESSION['apt_id'];

include $basedir .'models/payments.php';
$res = json_decode(getReturnedPayments($edf, $aptid));

if($res->status == true){
    if($res->table != false){

        $twig = new LoadTwigWithGlobals($_globals['view']);

        echo $twig->render(
            'views/tables/table1.html.twig',
            array(
                'table' => $res->table
            )
        );
    }else{
        echo false;
    }

}else{
    // Error de la base de datos
    echo 'Error interno: '.$res;
}
