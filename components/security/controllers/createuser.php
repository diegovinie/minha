<?php
/* components/security/controllers/createuser.php
 *
 *
 */
defined('_EXE') or die('Acceso restringido');

include ROOTDIR.'/models/validations.php';
include ROOTDIR.'/models/tokenator.php';

include ROOTDIR.'/tests/getpost.php'; die;

checkFormToken($_POST['token']);

$name = (string)validateName($_POST['name']);
$surname = (string)validateSurname($_POST['surname']);
$email = (string)validateEmail($_POST['email']);
$pwd = (string)validatePassword($_POST['pwd']);
$edf = (string)$_POST['edf'];
$apt = (string)$_POST['apt'];
$cond = (int)$_POST['cond'];
$type = 2;
$active = 0;

include $basedir.'models/createuser.php';

echo createUser(
    $name,
    $surname,
    $email,
    $edf,
    $apt,
    $cond,
    $type,
    $active,
    $pwd
);
