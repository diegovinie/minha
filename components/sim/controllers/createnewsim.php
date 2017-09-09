<?php
/* components/sim/controllers/createsim.php
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
$userName = (string)$_POST['name'];
$surname = (string)$_POST['surname'];

if(isset($_SESSION['id'])){
    $userId = (int)$_SESSION['id'];
}
else{
    echo jsonResponse(false, "Sin registro del usuario.");
    exit;
}

// El prefijo de las tablas
$prx = "s1_";

define('_SIM', 1);
include __DIR__.'/createsim.php';
