<?php
/* components/payments/controllers/getpendingpayments.php
 *
 */

defined('_EXE') or die('Acceso restringido');

$bui = (string)$_SESSION['bui'];
$napt = (int)$_SESSION['number_id'];

include $basedir .'models/payments.php';
$res = json_decode(getPendingPayments($bui, $napt));

if($res->status == true){
    if($res->table != false){
        $loader = new Twig_Loader_Filesystem(ROOTDIR.'/');
        $twig = new Twig_Environment($loader);

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
