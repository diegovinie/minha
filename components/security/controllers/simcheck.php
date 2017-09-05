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
$simId = isset($_POST['sim'])? (int)$_POST['sim'] : null;

sleep(1);
checkFormToken($_POST['token']);

$userid = checkUserPassword($user, $pwd, $rem);

if(!$userid){
    echo jsonResponse(false, "Usuario o Clave inválidos.");
    exit;
}
else{
    if($simId === null){

        $sims = displaySimList($userid);

        $twig = new LoadTwigWithGlobals($_globals['view']);

        $html = $twig->render(
            'components/sim/views/login/selectsim.html.twig',
            array(
                'sims' => $sims
            )
        );
        echo jsonResponse('sim', $html);
    }
    elseif(is_integer($simId)){

        if($simId === 0){
            if(!isset($_SESSION)) session_start();
            $_SESSION['id'] = $userid;

            echo jsonResponse('new', 'Redireccionando.');
        }
        else{
            $res2 = setSession($userid, $simId);

            if($res2) echo jsonResponse(true, "Aprobado.");
        }
    }

}
