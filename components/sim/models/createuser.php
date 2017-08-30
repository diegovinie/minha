<?php

/**
 * @return string@string
 */
function genEmail(/*string*/ $name=null, /*int*/ $id=null){

    include_once ROOTDIR.'/models/locale.php';

    $name = $name? $name : 'usuario';

    $doms = array(
        'fmail.com', 'yahou.es', 'mns.edu.mx', 'hogmail.com', 'identi.ca', 'cntv.gob.ve'
    );

    $n = $name? split(' ', strtolower($name)) : ['usuario'] ;
    $res = cleanString($n[0])
            .($id? $id : '')
            .'@'.$doms[array_rand($doms)];

    return $res;
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
function createUser(/*string*/ $name=null, /*int*/ $id=null){

    $hab['email'] = $email = genEmail($name, $id);

    // El 1,88% están inactivos.
    $hab['active'] = mt_rand() % 53? 1 : 0;

    // El 25% fija pregunta de seguridad.
    if(!(mt_rand() % 4)){
        list($hab['question'], $hab['response']) = genQuestion();
    }
    else{
        $hab['question'] = '';
        $hab['response'] = null;
    }


    $card = "Nuev".($gr? 'a' : 'o')." usuari".($gr? 'a' : 'o')."
            \nNombres: $name
            \nApellidos: $surname
            \nCorreo: $email
            \nC.I.: $ci
            \nNum. Cel: $cel
            \nGénero: $gender";

    return $hab;
}
