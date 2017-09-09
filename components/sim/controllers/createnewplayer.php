<?php
/* components/sim/controllers/createplayer.php
 *
 */

include_once ROOTDIR.'/models/db.php';
include_once ROOTDIR.'/models/modelresponse.php';
include_once ROOTDIR.'/controllers/ajax.php';
include_once ROOTDIR.'/models/validations.php';
include_once ROOTDIR.'/models/tokenator.php';

/*** Validando datos ***/



$useredf = (string)$_POST['edf'];
$userapt = (string)$_POST['apt'];
$email = (string)$_POST['email'];
$pwd = (string)$_POST['pwd'];
$userName = (string)$_POST['name'];
$surname = (string)$_POST['surname'];

include_once ROOTDIR.'/components/security/models/users.php';
$chk = checkEmail($email);

if($chk != false){
    echo jsonResponse(false, "Usuario ya registrado.");
    exit;
}

// El prefijo de las tablas
$prx = "s1_";

/*** INICIO ***/

if(key_exists('SERVER_PROTOCOL', $_SERVER)) ob_end_clean();

/*** Preparando Datos ***/

sleep(1);

// Chequea, añade al usuario en la tabla users y retorna el id
include $basedir.'models/addcurrentuser.php';

$re[] = $userId = addUserUsers($email, $pwd);
if(!$userId) ajaxErrorResponse('Error registrar usuario.');

define('_SIM', 1);
include __DIR__.'/createsim.php';
