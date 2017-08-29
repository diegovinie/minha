<?php

include ROOTDIR.'/models/validations.php';

// Validar el token
require ROOTDIR.'/models/tokenator.php';
checkFormToken($_POST['token']);

$habid = (integer)$_SESSION['hab_id'];

$name = validateName($_POST['name']);
$surname = validateSurname($_POST['surname']);
$ci = validateCi($_POST['ci']);
$nac = validateDate($_POST['nac']);
$cel = validateCel($_POST['cel']);
$gender = validateGender($_POST['gender']);

include $basedir.'models/profile.php';

echo updateHabitants($habid,
                    $name,
                    $surname,
                    $ci,
                    $nac,
                    $cel,
                    $gender);
