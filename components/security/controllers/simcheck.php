<?php
/* components/security/controllers/checkuser.php
 *
 * Controlador secundario
 */
defined('_EXE') or die('Acceso restringido');

include_once ROOTDIR.'/components/security/models/authentication.php';
include_once ROOTDIR.'/models/tokenator.php';
include_once ROOTDIR.'/models/validations.php';
include_once ROOTDIR.'/models/modelresponse.php';

//$user = (string)validateEmail($_POST['user']);

$user = (string)$_POST['user'];
$pwd = (string)$_POST['pwd'];
$rem = isset($_POST['remember']) ? 1 : 0;
sleep(1);
checkFormToken($_POST['token']);

$userid = checkUserPassword($user, $pwd, $rem);
if(!$userid){
    echo jsonResponse(false, "Usuario o Clave inválidos.");
    exit;
}
else{
    $simid = getSimulations($userid);

    if(!$simid){
        $msg = "No tiene simulaciones activas.";
        echo jsonResponse(false, $msg);
    }
    elseif(is_integer($simid)){
            echo $simid;
        $res2 = setSession($userid, $simid);

        if($res2) header("Location: /index.php/");
    }
    elseif(is_array($simid)){

        $arr = displaySimList($userid);

        var_dump($arr); die;
        
        echo jsonResponse(true, "elija su escenario");
        exit;
    }
    else{
        echo 'fin';
    }
}
