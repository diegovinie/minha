<?php

include ROOTDIR.'/models/validations.php';

// Validar el token
require ROOTDIR.'/models/tokenator.php';
checkFormToken($_POST['token']);

$id = (integer)$_SESSION['user_id'];

$name = validateName($_POST['name']);
$surname = validateSurname($_POST['surname']);
$ci = validateCi($_POST['ci']);
//$date = validateDate($_POST['date']);
$cel = validateCel($_POST['cel']);
$gender = validateGender($_POST['gender']);

include $basedir.'models/profile.php';

echo updateUserdata($id,
                    $name,
                    $surname,
                    $ci,
                    $cel,
                    $gender);
