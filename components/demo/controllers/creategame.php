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

//$apts = call_user_func("genTemplate{$edf}");
//if(!$apts) die('Error al crear plantilla de edificio.');

//$bui = createBuilding($apts, $userapt);
//if(!$bui) die('Error al crear edificio.');

$tableNames = array(
    'buildings',
    'subjects',
    'users',
    'providers',
    'funds',
    'accounts',
    'bills',
    'charges',
    'payments',
    'commitments'
);

foreach ($tableNames as $name) {
    include_once(ROOTDIR."/init/database/create{$name}table.php");

    echo "$name : ";
    $results[] = call_user_func("create{$name}Table", $prx);
    echo "\n";
}

print_r($results); die;

include $basedir.'models/preparedb.php';

//createBuildingsTable($prx);

//createUsersTable($prx);

createUserdataTable($prx);

setBuildingsData($prx, $bui);

setUsersData($prx, $bui);

addCurrentUser($prx, $email, $pwd, $name, $surname, $edf, $userapt);

header("Location: /index.php");
