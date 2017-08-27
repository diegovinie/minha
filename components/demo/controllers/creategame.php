<?php


$edf = (string)$_POST['edf'];
$userapt = (string)$_POST['apt'];
$email = (string)$_POST['email'];
$pwd = (string)$_POST['pwd'];
$name = (string)$_POST['name'];
$surname = (string)$_POST['surname'];

include_once ROOTDIR.'/models/db.php';

include $basedir.'models/addcurrentuser.php';

addGameTable($email);

$prx = getPrefix($email);
if(!$prx) die('Error al seleccionar prefijo.');

include $basedir.'models/createuser.php';
include $basedir.'models/createbuilding.php';

$apts = call_user_func("genTemplate{$edf}");
if(!$apts) die('Error al crear plantilla de edificio.');

$bui = createBuilding($apts, $userapt);
if(!$bui) die('Error al crear edificio.');

include ROOTDIR.'/init/database/createbuildingstable.php';
include ROOTDIR.'/init/database/createuserstable.php';
include ROOTDIR.'/init/database/createuserdatatable.php';

include $basedir.'models/preparedb.php';


createBuildingsTable($prx);

createUsersTable($prx);

createUserdataTable($prx);

setBuildingsData($prx, $bui);

setUsersData($prx, $bui);

addCurrentUser($prx, $email, $pwd, $name, $surname, $edf, $userapt);

header("Location: /index.php");
