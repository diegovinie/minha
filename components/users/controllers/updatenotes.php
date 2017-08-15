<?php


$buiid = $_SESSION['number_id'];

if($_SESSION['bui'] == 'A17'){

    // Solo válido para el A17 -acomodar-
    $notes = Array( 'multi' => isset($_POST['multi'])? true : false,
                'uni' => isset($_POST['uni'])? true : false,
                'abacantv' => isset($_POST['abacantv'])? $_POST['abacantv'] : false,
                'tvcantv' => isset($_POST['tvcantv'])? $_POST['tvcantv'] : false,
                'telcantv' => isset($_POST['telcantv'])? $_POST['telcantv'] : false,
                'gas' => isset($_POST['gas'])? $_POST['gas'] : false,
                'directv' => isset($_POST['directv'])? $_POST['directv'] : false,
                'cars' => isset($_POST['cars'])? $_POST['cars'] : false,
                'motos' => isset($_POST['motos'])? $_POST['motos'] : false);

}
else{
    $notes = '';
}

include $basedir .'models/profile.php';
echo updateNotes($buiid, json_encode($notes));
