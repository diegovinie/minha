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

function genDummyEmail(/*string*/ $name, /*int*/ $id=null){

    include_once ROOTDIR.'/models/locale.php';

    $n = split(' ', strtolower($name));
    $res = cleanString($n[0])
            .($id? $id : '')
            .'@dummy.net.ve';

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
