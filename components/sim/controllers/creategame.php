<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';
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



/*** INICIO ***/

ob_end_clean();
/*sleep(1);
ajaxProgressResponse(10, "Preparando 1...");
sleep(1);
ajaxProgressResponse(40, "Preparando 1...");
sleep(1);
ajaxProgressResponse(60, "Preparando 1...");
sleep(1);
ajaxFinalResponse(true, count($_POST), "Listo");

die;*/

$simTableNames = array(
  'actypes',
  'activities'
);

$userTableNames = array(
    'apartments',
    'subjects',
    'providers',
    'skills',
    'funds',
    'habitants',
    'accounts',
    'bills',
    'charges',
    'payments',
    'commitments'
);


/*** Preparando Datos ***/

ajaxProgressResponse(10, "Preparando Datos...");
sleep(1);

include $basedir.'models/addcurrentuser.php';
$re[] = $userid = addUserUsers($email, $pwd);
if(!$userid) ajaxErrorResponse('Error registrar usuario.');

$re[] = addUserSimulator($email);
$re[] = $simId = getLastUserSimId($email);
if(!$simId) ajaxErrorResponse('Error al recuperar sim id.');

$prx = "u{$simId}_";
if(!$prx) ajaxErrorResponse('Error al seleccionar prefijo.');

//$simEmail = "sim_".$simId."@".DB_SMTP;

include $basedir.'models/createhabitant.php';
include $basedir.'models/createcommunity.php';

$apts = call_user_func("genTemplate{$useredf}");
if(!$apts) ajaxErrorResponse('Error al crear los apartamentos.');

$cmty = createCommunity($apts, $userapt);
if(!$cmty) ajaxErrorResponse('Error al crear la comunidad.');


/*** Creando Entorno ***/

ajaxProgressResponse(20, "Creando Entorno...");

foreach ($simTableNames as $nameTable) {
    include_once(ROOTDIR."/app/database/create/create{$nameTable}table.php");

    $re[] = call_user_func("create{$nameTable}Table", $prx);
}


foreach ($userTableNames as $nameTable) {
    include_once(ROOTDIR."/app/database/create/create{$nameTable}table.php");

    $re[] = call_user_func("create{$nameTable}Table", $prx);
}



/*** Preparando Actividades ***/

ajaxProgressResponse(30, "Preparando Actividades...");

include $basedir.'models/preparesimtables.php';

$re[] = setDataActypesTable();
$re[] = setDataActivitiesTable();

include $basedir.'models/preparedb.php';


/*** Creando Comunidad ***/

ajaxProgressResponse(60, "Creando viviendas...");

/*** Creando Apartamentos ***/
$re[] = setApartmentsData($prx, $apts);



/*** Creando Habitantes ***/
ajaxProgressResponse(80, "Creando la comunidad...");


$re[] = setHabitantsData($prx, $cmty, $userid);

$re[] = addUserHabitants($prx, $email, $userName, $surname, $useredf, $userapt);

/*** Revisando errores ***/
if(array_sum($re) == count($re)){

    $status = false;
    $msg = "Algunos errores fueron encontrados.";
}
else{
    $status = true;
    $msg = "Finalizado con éxito.";
}

ajaxFinalResponse($status, $msg, "Listo");
//header("Location: /index.php");
