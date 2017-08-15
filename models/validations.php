<?php
/* models/validations.php
 *
 * Funciones para validar campos
 *
 * Retorna json(status, msg)
 */

defined('_EXE') or die('Acceso restringido');

function validateInput($val, $exp, $message){
    $status = false;
    $msg = '';

    $res = preg_match($exp, $val);

    if(!$res){
        $msg = $message;
    }
    else{
        $status = true;
      }

    return json_encode(array(
        'status' => $status, 'msg' => $msg));
}

function validateCi($ci){

    $exp = "/^(V|E)\d{7,8}$/";
    $msg = 'Error en el número de cédula.';

    return validateInput($ci, $exp, $msg);
}

function validateCel($cel){

    $exp = "/^04(12|14|16|24|26)\d{7}$/";
    $msg = 'Error en el número celular.';

    return validateInput($cel, $exp, $msg);
}

function validateDate($date){
    $exp = "/^(19\d{2}|20[0-1]\d)-(0\d|1[0-2])-([0-2]\d|3[0-1])$/";
    $msg = 'Error al introducir la fecha.';

    return validateInput($date, $exp, $msg);
}

function validateGender($gender){
    $exp = "/^(M|F)$/";
    $msg = 'Error al introducir el género.';

    return validateInput($gender, $exp, $msg);
}

function validateEmail($email){
    $exp = "/^[a-zA-Z_\d]{3,}@[a-zA-Z_\d]{3,}\.[a-zA-Z_\d]{2,}/";
    $msg = 'Error al introducir el correo electrónico.';

    return validateInput($email, $exp, $msg);
}

function validateName($name){
    $exp = "/^(?<name>[A-Z](\.|[a-z]+))(\s(?&name))?$/";
    $msg = 'Error al introducir nombres.';

    return validateInput($name, $exp, $msg);
}

function validateSurname($surname){
    $exp = "/^(?<name>[A-Z](\.|[a-z]+))(\s(?&name))?$/";
    $msg = 'Error al introducir apellidos.';

    return validateInput($surname, $exp, $msg);
}
