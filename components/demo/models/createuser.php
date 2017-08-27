<?php

/**
 * @return string
 */
function genName(/*string*/ $gender){

    $males = array(
        'Antonio', 'José', 'Manuel', 'Francisco', 'Juan', 'David', 'Diego', 'José Manuel',
        'José Antonio', 'José Luis', 'Jesús', 'Javier', 'Francisco Javier', 'Marcos', 'Gabriel',
        'Carlos', 'Daniel', 'Miguel', 'Rafael', 'Pedro', 'José Manuel',
        'Ángel', 'Alejandro', 'Miguel Ángel', 'José María', 'Fernando', 'Carlos Alberto', 'Luis Enrique', 'Esteban', 'Ernesto José', 'Arturo',
        'Luis', 'Sergio', 'Pablo', 'Jorge', 'Alberto',
    );
    $females = array(
        'María Carmen', 'María', 'Carmen', 'Josefa', 'Isabel', 'Ana María', 'Andreína', 'Vanessa', 'Valeria', 'Mariú', 'Catalina', 'María Antonieta', 'Elisabeth', 'Ana Gabriela', 'María Alejandra', 'Erika', 'Luz Marína',
        'María Dolores', 'María Pilar', 'María Teresa', 'Ana', 'Francisca',
        'Laura', 'Antonia', 'Dolores', 'María Angeles', 'Cristina', 'Marta',
        'María José', 'María Isabel', 'Pilar', 'María Luisa', 'Concepción',
        'Lucía', 'Mercedes', 'Manuela', 'Elena', 'Rosa María',
    );

    $select = $gender ? $females : $males;

    return $select[array_rand($select)];
}

/**
 * @return string
 */
function genSurname(){

    $snames = array(
        'García', 'González', 'Rodríguez', 'Fernández', 'López', 'Martínez', 'Contreras', 'Vivas', 'Pausini', 'Graterol', 'Villalobos', 'Morales',
        'Querales', 'Villegas', 'Ochoa', 'Berroterán', 'Moya', 'Noriega', 'Mathaus', 'Miller', 'Córdova', 'Cabrera', 'Guillén', 'Sosa', 'Fasano',
        'Sánchez', 'Pérez', 'Gómez', 'Martín', 'Jiménez', 'Ruiz',
        'Hernández', 'Díaz', 'Moreno', 'Álvarez', 'Muñoz', 'Romero',
        'Alonso', 'Gutiérrez', 'Navarro', 'Torres', 'Domínguez', 'Vázquez',
        'Ramos', 'Gil', 'Ramírez', 'Serrano', 'Blanco', 'Suárez', 'Molina',
        'Morales', 'Ortega', 'Delgado', 'Castro', 'Ortíz', 'Rubio', 'Marín',
        'Sanz', 'Iglesias', 'Nuñez', 'Medina', 'Garrido'
    );

    $res = $snames[array_rand($snames)];

    if(mt_rand() % 3) $res .= ' '.$snames[array_rand($snames)];

    return $res;
}

/**
 * @return string
 */
function genCi(){

    // El 10% son extranjeros.
    $nac = mt_rand() % 10? 'V' : 'E';

    $num = $nac == 'E'? mt_rand(80000000, 84000000)
                       : mt_rand(8000000, 20000000);

    return $nac.$num;
}

/**
 * @return string@string
 */
function genEmail(/*string*/ $name, /*int*/ $id=null){

    include_once ROOTDIR.'/models/locale.php';

    $doms = array(
        'fmail.com', 'yahou.es', 'mns.edu.mx', 'hogmail.com', 'identi.ca', 'cntv.gob.ve'
    );

    $n = split(' ', strtolower($name));
    $res = cleanString($n[0])
            .($id? $id : '')
            .'@'.$doms[array_rand($doms)];

    return $res;
}

/**
 * @return string
 */
function genCel(){

    $provs = array('0412', '0414', '0416', '0424', '0426');

    $num = $provs[array_rand($provs)];
    $num .= '-'.mt_rand(1000000, 9999999);

    return $num;
}

/**
 * @return string(YYY-M-D)
 */
function genBirthdate(/*string*/ $ci=null){

    $rel = array(
        '8' => 1968,        '9' => 1970,        '10' => 1973,
        '11' => 1974,        '12' => 1977,        '13' => 1980,
        '14' => 1981,        '15' => 1984,        '16' => 1985,
        '17' => 1987,        '18' => 1989,        '19' => 1991,
        '20' => 1994
    );
    //print_r($rel); die;
    if($ci){
        $num = (int)preg_replace("/[^0-9]*/", '', $ci);
        $n = intval($num / 1000000);

        $y = array_key_exists($n, $rel)? $rel[$n] : mt_rand(1950, 1988);
    }
    else{
        $y = mt_rand(1950, 1999);
    }

    $m = mt_rand(1, 12);
    $d = mt_rand(1, 28);

    return "$y-$m-$d";
}

/**
 * @return array(2)
 */
function genQuestion(){

    $pairs = array(
        'Cien años de Soledad'  => 'García Márquez',
        'La Tregua'             => 'Benedetti',
        'Rayuela'               => 'Cortázar',
        'Por quien doblan las campanas' => 'Hemingway',
        'El Túnel'              => 'Sábato',
        'La República'          => 'Platón',
        'El Capital'            => 'Marx',
        'El Estado y la Revolución' => 'Lenin'
    );

    $r = array_rand($pairs);
    foreach ($pairs as $ques => $res) {
        if($pairs[$r] == $res) return array(
                                $ques,
                                $res);
    }
}

/**
 * @return array
 */
function createUser(/*int*/ $id=null){

    // El 50% son mujeres.
    $gr = mt_rand() % 2;
    $user['gender'] = $gender = $gr? 'F' : 'M';

    $user['name'] = $name = genName($gr);

    $user['pwd'] = '1234';

    $user['surname'] = $surname = genSurname();

    $user['email'] = $email = genEmail($name, $id);

    // El 66% indica cédula de identidad.
    $user['ci'] = $ci = mt_rand() % 3? genCi() : null;

    // El 50% indica fecha de nacimiento.
    $c = $ci? $ci : 0;
    $user['nac'] = mt_rand() % 2? genBirthdate($c) : null;

    // El 50% indica número celular.
    $user['cel'] = $cel = mt_rand() % 2? genCel() : null;

    // El 75% son titulares, el resto familiares.
    $user['cond'] = mt_rand() % 4? 1 : 0;

    // Entre los titulares el 2% son administradores.
    $user['type'] = $user['cond'] && mt_rand() % 50? 1 : 2;

    // El 12,50% están inactivos.
    $user['active'] = mt_rand() % 8? 1 : 0;

    // El 25% fija pregunta de seguridad.
    if(!(mt_rand() % 4)){
        list($user['question'], $user['response']) = genQuestion();
    }
    else{
        $user['question'] = '';
        $user['response'] = null;
    }


    $card = "Nuev".($gr? 'a' : 'o')." usuari".($gr? 'a' : 'o')."
            \nNombres: $name
            \nApellidos: $surname
            \nCorreo: $email
            \nC.I.: $ci
            \nNum. Cel: $cel
            \nGénero: $gender";

    return $user;
}
