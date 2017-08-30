<?php

function genName($especialidad){

    $list = array(
        'ferreteria' => array(
            'Ferretería Hermanos Pérez',
            'Materiales TJD',
            'Ferretotal',
            'EPA'
        ),
        'ascensores' => array(
            'Ascensores Eternity C.A.',
            'Proyecto Mecatrónicos C.A',
            'Cooperativa de Ascensores Vencedores'
        ),
        'pintura' => array(
            'Construcciones Jimenez C.A',
            'Decoración Fashion C.A',
            'Ferrepinturas de Caracas'
        ),
        'plomeria' => array(
            'Tuberías de Caracas C.A',
            'Cooperativa Destapatodo',
            'Corporación del Drenaje',
            'Plomeros Anónimos C.A'
        ),
        'electricidad' => array(
            'Electrohogar C.A',
            'Proyectos Eléctricos C.A',
            'Cooperativa de Servicios Eléctricos'
        )
    );

    if(in_array($especialidad, $list)){
        return array_rand($list[$especialidad]);
    }
    else{
        return "Todo Servicios C.A.";
    }


}

function getRif(){
    
        return "J".mt_rand(200000000, 500000000);
}

function genAddress(){

    $city = array(
        'Caracas',
        'Guarenas',
        'Los Teques'
    );

    $av = array(
        'Av. Libertador',
        'Av. Bolivar',
        'Av. Francisco de Miranda',
        'Av. Rómulo Gallegos',
        'Av. San Martín',
        'Av. Baralt',
    );

    return array_rand($av).", ".array_rand($city);
}

function genEmail($name){
    include_once ROOTDIR.'/models/locale.php';

    $n = split(' ', strtolower($name));
    $res = cleanString($n[0])
            .($id? $id : '')
            .'@dummy.net.ve';

    return $res;
}

function genCel(){

        $provs = array('0412', '0414', '0416', '0424', '0426');

        $num = $provs[array_rand($provs)];
        $num .= '-'.mt_rand(1000000, 9999999);

        return $num;
}

function genAlias(){

}
