<?php
/* components/demo/models/createbuilding.php
 *
 */

/**
 * @return array[][]
 */
function genTemplateA17(){

    $levels = 15;
    $t = $levels * (2*3 + 4*2 + 2);

    $specs = array(
        "A" => 3,
        "B" => 2,
        "C" => 2,
        "D" => 3,
        "E" => 2,
        "F" => 1,
        "G" => 1,
        "H" => 2
    );

    for($level = 1; $level <= $levels; $level++){

        foreach ($specs as $letter => $w) {
            $apt = array();
            $apt['apt'] = $level.$letter;
            $apt['assigned'] = mt_rand() % 25? 1 : 0;
            $apt['weight'] = round($w/$t, 6);
            $apt['name'] = 'A17';
            $apt['occupied'] = 0;
            $apt['notes'] = '';
            $apts[] = $apt;
        }
    }
    return $apts;
}

/**
 * @return array[][]
 */
function genTemplateCountry_Park(){


    $i = 14;
    $sum = 0.0;
    while($i--){
        $rnd = round(mt_rand(6300000, 6700000) / 1000000, 6);
        $per[] = $rnd;
        $sum += $rnd;
    }

    $per[] = 100.0000 - $sum;

    $list = array(
        "M1",        "M2",        "1",        "2",
        "3",        "4",        "5",        "6",
        "7",        "8",        "9",        "10",
        "11",        "12",        "PH",
    );

    foreach ($list as $ind => $name) {
        $apt = array();
        $apt['apt'] = $name;
        $apt['assigned'] = 1;
        $apt['weight'] = $per[$ind];
        $apt['name'] = 'Country_Park';
        $apt['occupied'] = 0;
        $apt['notes'] = '';
        $apts[] = $apt;
    }
    return $apts;
}

/**
 * @return json
 */
function genNotes(){

    return '{"todo": true}';
}

/**
 * @return array[][][]
 */
function createBuilding(/*array*/ $apts, /*string*/ $userapt=null){

    // Se generan los usuarios para cada apartamento.
    $id = 1;
    foreach ($apts as $apt) {

        // Si está asignado se crean usuarios.
        if($apt['assigned'] == 1 && $apt['apt'] != $userapt){
            // Se crean usuarios hasta que salga el titular.
            $principal = 0;
            while(!$principal){
                $user = createUser($id++);
                $apt['users'][] = $user;
                $principal = $user['cond'];
            }
            // Se generan las notas.
            $apt['occupied'] = mt_rand() % 12? 1 : 0;
            $apt['notes'] = genNotes();
        }
        // Se agrega el apartamento al edificio
        $bui[] = $apt;
    }
    return $bui;
}

/**
 * Ejecuta y graba el eco de createBuilding()
 * @return bool
 */
function saveBuilding(/*string*/ $edif, /*string*/ $filename=null){

    $apts = call_user_func("genTemplate{$edif}");

    $bui = createBuilding($apts);

    ob_start();
    print_r($bui);
    $res = ob_get_clean();

    $file = $filename? $filename : 'prueba.txt';

    $hdr = fopen($file, 'w');
    fwrite($hdr, $res);
    fclose($hdr);

    return true;
}
