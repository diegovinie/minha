<?php

include_once __DIR__.'/human.php';

/**
 * @return array
 */
function createHabitant(/*int*/ $id=null){

    // El 50% son mujeres.
    $gr = mt_rand() % 2;
    $hab['gender'] = $gender = $gr? 'F' : 'M';

    $hab['name'] = $name = genName($gr);

    $hab['surname'] = $surname = genSurname();

    // El 66% indica cédula de identidad.
    $hab['ci'] = $ci = mt_rand(0, 99) < 66? genCi() : null;

    // El 50% indica fecha de nacimiento.
    $c = $ci? $ci : 0;
    $hab['nac'] = mt_rand() % 2? genBirthdate($c) : null;

    // El 50% indica número celular.
    $hab['cel'] = $cel = mt_rand() % 2? genCel() : null;

    // El 15% no están aceptados aún.
    $hab['accepted'] = mt_rand(0, 99) < 85? 1 : 0;

    // El 66% son titulares, el resto familiares.
    $hab['cond'] = mt_rand(0, 99) < 66? 1 : 0;

    // Entre los titulares el 5% son administradores.
    $hab['role'] = $hab['cond'] == 1
        && $hab['accepted'] == 1
        && mt_rand(0, 99) < 5? 1 : 2;


    $card = "Nuev".($gr? 'a' : 'o')." usuari".($gr? 'a' : 'o')."
            \nNombres: $name
            \nApellidos: $surname
            \nC.I.: $ci
            \nNum. Cel: $cel
            \nGénero: $gender";

    return $hab;
}
