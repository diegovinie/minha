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

    if(!$val) return null;

    $res = preg_match($exp, $val);

    if(!$res){
        $msg = $message;
    }
    else{
        return $val;
      }

    $response = json_encode(array(
        'status' => $status, 'msg' => $msg));

    die($response);
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

function validatePassword($password){

    $n1 = 6;
    $exp1 = "/^.{".$n1.",}$/";
    $msg1 = "La clave debe tener al menos $n1 caractéres.";
    $res1 = validateInput($password, $exp1, $msg1);

    $n2 = 2;
    $exp2 = "/[0-9]{".$n2.",}/";
    $msg2 = "La clave debe tener al menos $n2 números.";
    $res2 = validateInput($password, $exp2, $msg2);

    $n3 = 2;
    $exp3 = "/[a-zA-Z]{".$n3.",}/";
    $msg3 = "La clave debe tener al menos $n3 letras.";
    $res3 = validateInput($password, $exp3, $msg3);

    return $res3;
}
