<?php
//Se construyen los recibos
require_once '../datos.php';
require_once ROOTDIR.'server.php';
connect();

//$user = $_SESSION['user'];
// extract($_GET);
switch ($_GET['fun']) {
    case 'generate':
//        print_r (generate($user, $_GET));
        break;
    case 'save_fact':
        print_r($fun($number));
        break;
    case 'discard':
        print_r($fun($number));
        break;
    case 'gen_A17_table':
        echo $fun();
        break;
    case 'porc':
        echo $fun();
        break;
    default:
        echo "Error";
        break;
}

function generate($user, $data_ar){
    $periodo = $data_ar['lapse']; // Periodo (mes) de los recibos

    $porc = round(porc(), 4); // Porcentaje de los apartamentos

    // Seleciona los datos del periodo
    $q = "SELECT * FROM lapses WHERE lap_id = '$periodo'";
    $rlapse = q_exec($q);
    $lap_ar = query_to_array($rlapse);
    $month = $lap_ar[0]['lap_month'];
    $year = $lap_ar[0]['lap_year'];
    if($month <= 10){
        $mo = '0'.$month; // Para que el mes siempre tenga 2 digitos
    }else{
        $mo = ''.$month;
    }
    $fac_number = $year.$mo; // Se une mes y aǹo para el num de rec

    // Selecciona los gastos hechos que se seleccionaron
    $arg_bills = '';
    $q = "SELECT bil_total, bil_name, up_alias, up_op FROM bills INNER JOIN usual_providers ON bil_name = up_name WHERE ";
    foreach ($data_ar as $key => $value) {
        if(is_integer($key) && $value == 1){
            $arg_bills .= "bil_id = $key"." OR ";
        }
    }
    // Se limpian los argumentos
    $arg_bills_2 = substr($arg_bills, 0, strripos($arg_bills, "OR"));
    $q1 = $q.$arg_bills_2;
    $r1 = q_exec($q1);
    $bills_ar = query_to_array($r1); // El Array de los gastos

    // Selecciona los apartamentos y sus pesos ponderados
    $q2 = "SELECT A17_number, A17_weight FROM A17 WHERE A17_assigned = 1";
    $r2 = q_exec($q2);
    $apts_ar = query_to_array($r2); // El Array de los apartamentos

    //Selecciona la cantidad de apartamentos contribuyentes
    $q4 = "SELECT COUNT(A17_id) AS `asignados` FROM A17 WHERE A17_assigned = 1";
    $r4 = q_exec($q4);
    $actives_ar = query_to_array($r4);
    $actives = $actives_ar[0]['asignados'];

    //Selecciona el balance previo a la generación
    $q5 = "SELECT SUM(cha_amount) AS `balance` FROM charges";
    $r5 = q_exec($q5);
    $bal_ar = query_to_array($r5);
    $balance = $bal_ar[0]['balance'];

    // Crea el array fondos: [n][name/type/def]
    $funds = [];
    $i = 0;
    foreach ($_GET as $key => $value) {
        if(stripos($key, 'name') === 0){
            $funds[$i]['name']= $value;
        }elseif(stripos($key, 'type') === 0){
            $funds[$i]['type']= $value;
        }elseif(stripos($key, 'def') === 0){
            $funds[$i++]['def']= $value;
        }
    }

    //Se genera el contenido
    foreach ($apts_ar as $index => $apt_val) {
        foreach ($bills_ar as $index2 => $bil_val) {
            $content[$apt_val['A17_number']][$bil_val['up_alias']]['nombre'] = $bil_val['up_alias'];
            $content[$apt_val['A17_number']][$bil_val['up_alias']]['porcentaje'] = round($bil_val['bil_total'] * $apt_val['A17_weight'] * $porc /100, 2);
            $content[$apt_val['A17_number']][$bil_val['up_alias']]['total'] = $bil_val['bil_total'];
            //Generar el campo del total a pagar por apartamento
            $sum = 0;
            $sum_total = 0;
            foreach($content[$apt_val['A17_number']] as $apt => $v){
                $sum += $content[$apt_val['A17_number']][$apt]['porcentaje'];
                $sum_total += $content[$apt_val['A17_number']][$apt]['total'];
            }
            $content2[$apt_val['A17_number']]['charged'] = $sum;
            $lastapt = $content[$apt_val['A17_number']];
        }
        //fondos
        foreach ($funds as $key => $value) {
            $valor = numToEng($value['def']);

            if($value['type'] == 1){
                $content[$apt_val['A17_number']][$value['name']]['nombre'] = $value['def'].' %';
                $content[$apt_val['A17_number']][$value['name']]['porcentaje'] = round($sum_total * ($valor /100), 2);
                $content[$apt_val['A17_number']][$value['name']]['total'] = round($sum_total * ($valor / 100), 2);
            }elseif($value['type'] == 2){
                $content[$apt_val['A17_number']][$value['name']]['nombre'] = 'Bs. '.$value['def'];
                $content[$apt_val['A17_number']][$value['name']]['porcentaje'] = round($valor / $actives, 2);
                $content[$apt_val['A17_number']][$value['name']]['total'] = $valor;
            }
            $lastapt = $content[$apt_val['A17_number']];
        }

    }

    // Se genera el nuevo sumario
    foreach ($lastapt as $key => $value) {
        $summary[$key] = $value['total'];
    }

    $tot = 0; // Total de los gastos y fondos
    foreach ($summary as $key => $value) {
        $tot += $value;
    }

    // Se genera la cabecera
    $head = ['fecha' => date('d-m-y'), 'Creador' => $user, 'Periodo' => $lap_ar[0]['lap_name'], 'Gen Num' => $fac_number,'Num Aptos' => $actives, 'MCD' => $porc, 'Monto Total' => $tot, 'Balance a la fecha' => ($balance + $tot)];

    //Se construye el array
    $table = [$head, $summary, $content];
    return $table;
    /*
    //Graba contenidos temporales de lo que se va a grabar en charges
    $charges_json = json_encode($content2) or die(json_last_error_msg());
    $file_cha = fopen(ROOTDIR.'files/tmp/charges'.$fac_number.'.json', 'w');
    fwrite($file_cha, $charges_json);
    fclose($file_cha);

    //Se pasa de array a json
    $type_json = json_encode($table) or die(json_last_error_msg());
    //Se crea el archivo y se guarda
    //$file = fopen(ROOTDIR.'files/fact-'.$year.'-'.$month.'.json', 'w');
    $file = fopen(ROOTDIR.'files/fact-'.$fac_number.'.json', 'w');
    fwrite($file, $type_json);
    fclose($file);
    return json_encode([$head, $summary]);
    */
}

function save_fact($fac_number){
    //Graba los datos temporales en charges
    $file = fopen(ROOTDIR.'files/tmp/charges'.$fac_number.'.json', "r");
    $b = fgets($file);
    $c = json_decode($b);
    //print_r($c);

    foreach ($c as $apto => $value) {
        $charg[$apto] = $value->{'charged'};
    }
    //Se insertan los datos en charges y se actualiza A17_balance
    foreach($charg as $apt => $total){
        //Se separa el select para evitar conflictos con el trigger
        $qnum = "SELECT A17_id FROM A17 WHERE A17_number = '$apt'";
        $rnum = mysql_fetch_array(q_exec($qnum));
        $qcharges = "INSERT INTO charges VALUES (NULL, $rnum[0] , $total, NULL, 'diego')\n";
    //    $rcharges = q_exec($qcharges);
    }
    return "Guardado con éxito";
}

function discard($fac_number){
    //elimina los datos temporales y la factura. json
    if(file_exists(ROOTDIR.'files/fact-'.$fac_number.'.json') && file_exists(ROOTDIR.'files/tmp/charges'.$fac_number.'.json')) {
        unlink(ROOTDIR.'files/fact-'.$fac_number.'.json');
        unlink(ROOTDIR.'files/tmp/charges'.$fac_number.'.json');
        $resp = "borrado";
    }else{
        $resp = "no se encuentra";
    }
    return $resp;
}

function gen_A17_table(){
    //Esta es copia de la función apartToString en datos.php
    $i = 0;
    $k = 1;
    for($i = 1; $i <= 15; $i++){
        $j = 0;
        $letters = 'ABCDEFGH';
        $a = '';
        $b = '';
        for($j = 0; $j < strlen($letters); $j++){
            $b = $letters[$j];
            $apart[$k] = $i.$b;
            $k++;
        }
    }
    //Crea un array relacionando las letras con el peso ponderado
    $array = [ "A" => 3, "B" => 2, "C" => 2, "D" => 3, "E" => 2, "F" => 1, "G" => 1, "H" => 2];
    foreach ($apart as $key => $number) {
        //Ubica la última pocisión en el apartamento (la letra)
        $letter = $number[strlen($number) - 1];
        foreach ($array as $key => $weight) {
            if($letter == $key){
                //Crea el array total que relaciona cada apartamento con su
                //respectivo peso
                $total[$number] = $weight;
            }
        }
    }
    $q1 = "INSERT INTO A17 VALUES \n";
    $q2 = '';
    foreach ($total as $number => $weight) {
        $q2 .= "(NULL, '$number', 0, $weight, 1, 1, NULL), \n";
    }
    //Construye y limpia la consulta y luego la ejecuta
    $a = $q1.$q2;
    $q3 = substr($a, 0, strripos($a, ','));
    $r = q_exec($q3);
    return true;
}

function porc(){
    $q = "SELECT A17_id, A17_number FROM A17 WHERE A17_assigned = 1";
    $r = q_exec($q);
    $r_asc = query_to_assoc($r);
    $apt_ar = ["large" => 0, "med" => 0, "small" => 0];
    $array = [ "A" => 3, "B" => 2, "C" => 2, "D" => 3, "E" => 2, "F" => 1, "G" => 1, "H" => 2];
    for($i = 0; $i < sizeof($r_asc); $i++){
        $number = $r_asc[$i]['A17_number'];
        $letter = $number[strlen($number) - 1];
        if($letter == "A" || $letter == "D"){
            $apt_ar['large'] += 1;
        }elseif($letter == "B" || $letter == "C" || $letter == "E" || $letter == "H"){
            $apt_ar['med'] += 1;
        }elseif($letter == "F" || $letter == "G"){
            $apt_ar['small'] += 1;
        }
    }
    $large = $apt_ar['large'];
    $med = $apt_ar['med'];
    $small = $apt_ar['small'];
    $part = 100 / (3*$large + 2*$med + $small);
    return $part;
}
 ?>
