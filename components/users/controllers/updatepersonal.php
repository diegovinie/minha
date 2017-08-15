<?php

include ROOTDIR.'/models/validations.php';

// Validar el token
require ROOTDIR.'/models/tokenator.php';
checkFormToken($_POST['token']);

$id = (integer)$_SESSION['user_id'];

// [nombre_var => [fun_validadora => valor_var]]
$doubleArray = array(
    'name'      => ['validateName' => $_POST['name']],
    'surname'   => ['validateSurname' => $_POST['surname']],
    'ci'        => ['validateCi' => $_POST['ci']],
    //'date'        => ['validateDate' => $_POST['date']],
    'cel'       => ['validateCel' => $_POST['cel']],
    'gender'       => ['validateGender' => $_POST['gender']]
);

// Validación de información
foreach ($doubleArray as $var => $group) {
    foreach ($group as $fun => $arg) {
        if($arg == ''){
            // Si la variable es vacía no detiene la ejecución
            ${"$var"} = $arg;
        }
        else{
            $res = json_decode($fun($arg));

            if($res->status == true){
                // Fija nombre_var = valor_var
                ${"$var"} = $arg;
            }
            else{
                // Manda respuesta al frontend
                echo json_encode($res);
                exit;
            }
        }
    }
}

include $basedir.'models/profile.php';

echo updateUserdata($id,
                    $name,
                    $surname,
                    $ci,
                    $cel,
                    $gender);
