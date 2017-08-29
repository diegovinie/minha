<?php


$edf = (string)$_POST['edf'];
$userapt = (string)$_POST['apt'];
$email = (string)$_POST['email'];
$pwd = (string)$_POST['pwd'];
$userName = (string)$_POST['name'];
$surname = (string)$_POST['surname'];

include_once ROOTDIR.'/models/db.php';

include $basedir.'models/addcurrentuser.php';

include $basedir.'models/simulatortable.php';

$simId = addGetSimulatorTable($email);
if(!$simId) die('Error al crear juego.');

$simEmail = "sim_".$simId."@".DB_SMTP;

$prx = getPrefix($email);
if(!$prx) die('Error al seleccionar prefijo.');

include $basedir.'models/createhabitant.php';
include $basedir.'models/createcommunity.php';

$apts = call_user_func("genTemplate{$edf}");
if(!$apts) die('Error al crear los apartamentos.');

$cmty = createCommunity($apts, $userapt);
if(!$cmty) die('Error al crear la comunidad.');

$simTableNames = array(
  'actypes',
  'activities'
);

foreach ($simTableNames as $nameTable) {
    include_once(ROOTDIR."/app/database/create{$nameTable}table.php");

    echo "\n$nameTable : ";
    $re[] = call_user_func("create{$nameTable}Table", $prx);
}

$userTableNames = array(
    'apartments',
    'subjects',
    'providers',
    'funds',
    'habitants',
    'accounts',
    'bills',
    'charges',
    'payments',
    'commitments'
);

foreach ($userTableNames as $nameTable) {
    include_once(ROOTDIR."/app/database/create{$nameTable}table.php");

    echo "\n$nameTable : ";
    $re[] = call_user_func("create{$nameTable}Table", $prx);
}
//include ROOTDIR.'/app/database/setglobaldata.php';

include $basedir.'models/preparedb.php';

$re[] = setApartmentsData($prx, $apts);
$re[] = addCurrentUser($prx, $email, $pwd, $userName, $surname, $edf, $userapt);
$re[] = setHabitantsData($prx, $cmty, $simEmail);

if(array_sum($re) == count($re)){
    print_r($re);
    die("Algunos errores fueron encontrados.");
}

//header("Location: /index.php");
