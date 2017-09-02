<?php
/* components/sim/controllers/createplayer.php
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

// El prefijo de las tablas
//$prx = "u2_";

/*** INICIO ***/

if(key_exists('SERVER_PROTOCOL', $_SERVER)) ob_end_clean();

/*** Preparando Datos ***/

ajaxProgressResponse(10, "Preparando Datos...");
sleep(1);

// Chequea, añade al usuario en la tabla users y retorna el id
include $basedir.'models/addcurrentuser.php';
$re[] = $userId = addUserUsers($email, $pwd);
if(!$userId) ajaxErrorResponse('Error registrar usuario.');

// Crea una nueva entrada en tabla simulator y retorna el id
$re[] = addUserSimulator($email);
$re[] = $simId = getLastUserSimId($email);
if(!$simId) ajaxErrorResponse('Error al recuperar sim id.');



include_once $basedir.'models/createcommunity.php';

// Genera la plantilla dependiendo del edificio
$apts = call_user_func("genTemplate{$useredf}");
if(!$apts) ajaxErrorResponse('Error al crear los apartamentos.');

// Retorna un array de habitantes por apartamento, crea los habitantes
$cmty = createCommunity($apts, $userapt);
if(!$cmty) ajaxErrorResponse('Error al crear la comunidad.');


/*** Preparando Actividades ***/

ajaxProgressResponse(30, "Preparando Actividades...");

include $basedir.'models/preparesimtables.php';



include $basedir.'models/preparedb.php';


/*** Creando Comunidad ***/

ajaxProgressResponse(60, "Creando viviendas...");

/*** Creando Apartamentos ***/
// Inserta los apartamentos en la BD
$re[] = setApartmentsData($prx, $apts, $simId);



/*** Creando Habitantes ***/
ajaxProgressResponse(80, "Creando la comunidad...");

// Inserta los habitantes en la BD
$re[] = setHabitantsData($prx, $cmty, $simId);

// Inserta los datos del usuario en BD
$re[] = addUserHabitants($prx, $userId, $simId, $email, $userName, $surname, $useredf, $userapt);

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
