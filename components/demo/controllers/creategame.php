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
include $basedir.'models/createcommunity.php';

$apts = call_user_func("genTemplate{$edf}");
if(!$apts) die('Error al crear plantilla de edificio.');

$cmty = createCommunity($apts, $userapt);
if(!$cmty) die('Error al crear edificio.');

$tableNames = array(
    'apartments',
    'subjects',
    'users',
    'providers',
    'funds',
    'accounts',
    'bills',
    'charges',
    'payments',
    'commitments',
    'userdata'
);

foreach ($tableNames as $nameTable) {
    include_once(ROOTDIR."/app/database/create{$nameTable}table.php");

    echo "\n$name : ";
    $re[] = call_user_func("create{$nameTable}Table", $prx);
}
//include ROOTDIR.'/app/database/setglobaldata.php';

include $basedir.'models/preparedb.php';

$re[] = setApartmentsData($prx, $apts);
$re[] = addCurrentUser($prx, $email, $pwd, $name, $surname, $edf, $userapt);
$re[] = setUsersData($prx, $cmty);

if(array_sum($re) == count($re)){
    print_r($re);
    die("Algunos errores fueron encontrados.");
}

header("Location: /index.php");
