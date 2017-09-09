<?php
/* components/sim/controllers/createsim.php
 *
 * Requiere:
 * (string)$useredf
 * (string)$userapt
 * (string)$email
 * (string)$userName
 * (string)$surname
 * (string)$prx
 * (int)$userId
 * (array)$re
 */

defined('_SIM') or die('No autorizado.');

include_once $basedir.'models/addcurrentuser.php';

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

include $basedir.'models/preparesimtables.php';
include $basedir.'models/preparedb.php';

/*** Creando Comunidad ***/

/*** Creando Apartamentos ***/

// Inserta los apartamentos en la BD
$re[] = setApartmentsData($prx, $apts, $simId);

include_once ROOTDIR.'/app/database/set/setdefaultsdata.php';
$re[] = setDataLapsesTable($simId);

$re[] = setDataProvidersTable($simId);

/*** Creando Habitantes ***/

// Inserta los habitantes en la BD
$re[] = setHabitantsData($prx, $cmty, $simId);

// Inserta los datos del usuario en BD
$re[] = addUserHabitants($prx, $userId, $simId, $email, $userName, $surname, $useredf, $userapt);

$habId = getHabitantId($userId);

$re[] = setAccountsData($habId, $simId);

include_once ROOTDIR.'/components/security/models/authentication.php';
$re[] = setSession($userId, $simId);

echo jsonResponse(true, "Finalizado con éxito.");
