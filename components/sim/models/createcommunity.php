<?php
/* components/demo/models/createcommunity.php
 *
 */

include_once __DIR__.'/createhabitant.php';

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
            $apt['name'] = $level.$letter;
            $apt['assigned'] = mt_rand() % 23? 1 : 0; // 4,34 no asignados
            $apt['weight'] = round($w/$t, 6);
            $apt['edf'] = 'A17';
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
        $rnd = round(mt_rand(6300000, 6700000) / 100000000, 6);
        $per[] = $rnd;
        $sum += $rnd;
    }

    $per[] = 1.0000 - $sum;

    $list = array(
        "M1",        "M2",        "1",        "2",
        "3",        "4",        "5",        "6",
        "7",        "8",        "9",        "10",
        "11",        "12",        "PH",
    );

    foreach ($list as $ind => $name) {
        $apt = array();
        $apt['name'] = $name;
        $apt['assigned'] = 1;
        $apt['weight'] = $per[$ind];
        $apt['edf'] = 'Country_Park';
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
function createCommunity(/*array*/ $apts, /*string*/ $userapt=null){

    // Se generan los usuarios para cada apartamento.
    $id = 1;
    foreach ($apts as $apt) {

        // Si está asignado se crean usuarios.
        if($apt['assigned'] == 1 && $apt['name'] != $userapt){
            // Se crean usuarios hasta que salga el titular.
            $principal = 0;
            while(!$principal){
                $hab = createHabitant($id++);
                $apt['habs'][] = $hab;
                $principal = $hab['cond'];
            }
            // Se generan las notas.
            $apt['occupied'] = mt_rand() % 12? 1 : 0;
            $apt['notes'] = genNotes();
        }
        // Se agrega el apartamento al edificio
        $cmty[] = $apt;
    }
    return $cmty;
}

/**
 * Ejecuta y graba el eco de createCommunity()
 * @return bool
 */
function saveCommunity(/*string*/ $edif, /*string*/ $filename=null){

    $apts = call_user_func("genTemplate{$edif}");

    $cmty = createCommunity($apts);

    ob_start();
    print_r($cmty);
    $res = ob_get_clean();

    $file = $filename? $filename : 'prueba.txt';

    $hdr = fopen($file, 'w');
    fwrite($hdr, $res);
    fclose($hdr);

    return true;
}
