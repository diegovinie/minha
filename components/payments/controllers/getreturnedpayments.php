<?php
/* components/payments/controllers/getreturnedpayments.php
 *
 */

defined('_EXE') or die('Acceso restringido');

$bui = (string)$_SESSION['bui'];
$napt = (int)$_SESSION['number_id'];

include $comdir .'payments/models/payments.php';
$res = json_decode(getReturnedPayments($bui, $napt));

if($res->status == true){

    $loader = new Twig_Loader_Filesystem(ROOTDIR.'/');
    $twig = new Twig_Environment($loader);

    echo $twig->render(
        'views/tables/table1.html.twig',
        array(
            'table' => $res->table
        )
    );

}else{
    // Error de la base de datos
    echo 'hola '.$res;
}
