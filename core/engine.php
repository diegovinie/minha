<?php
//Se construyen los recibos

if(!isset($_SESSION)) session_start();
$bui = $_SESSION['bui'];
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
        extract($_GET);
        print_r($fun($number));
        break;
    case 'discard':
        extract($_GET);
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
    $q = "SELECT bil_total, bil_class, up_alias, up_op FROM bills INNER JOIN usual_providers ON bil_name = up_name WHERE ";
    $qu = "UPDATE bills SET bil_lapse_fk = 99 WHERE ";
    foreach ($data_ar as $key => $value) {
        if(is_integer($key) && $value == 1){
            $arg_bills .= "bil_id = $key"." OR ";
        }
    }
    // Se limpian los argumentos
    $arg_bills_2 = substr($arg_bills, 0, strripos($arg_bills, "OR"));
    $q1 = $q.$arg_bills_2;
    $qu1 = $qu.$arg_bills_2;
    $r1 = q_exec($q1);
    $ru1 = q_exec($qu1);
    $bills_ar = query_to_array($r1); // El Array de los gastos

    // Selecciona los apartamentos y sus pesos ponderados
    $q2 = "SELECT bui_apt, bui_weight, bui_balance FROM buildings WHERE bui_assigned = 1 AND bui_name = '$bui'";
    $r2 = q_exec($q2);
    $apts_ar = query_to_array($r2); // El Array de los apartamentos

    //Selecciona la cantidad de apartamentos contribuyentes
    $q4 = "SELECT COUNT(bui_id) AS `asignados` FROM buildings WHERE bui_assigned = 1 AND bui_name = '$bui'";
    $r4 = q_exec($q4);
    $actives_ar = query_to_array($r4);
    $actives = $actives_ar[0]['asignados'];

    //Selecciona el balance previo a la generación
    //$q5 = "SELECT SUM(cha_amount) AS `balance` FROM charges";
    $q5 = "SELECT SUM(bui_balance) AS 'balance' FROM buildings WHERE bui_name = '$bui'"
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
        foreach ($bills_ar as $in => $bil_val) {
            $content[$apt_val['bui_apt']]['Comunes'][$in]['nombre'] = $bil_val['bil_class'] .' - ' .$bil_val['up_alias'] ;
            $content[$apt_val['bui_apt']]['Comunes'][$in]['porcentaje'] = round($bil_val['bil_total'] * $apt_val['bui_weight'] * $porc /100, 2);
            $content[$apt_val['bui_apt']]['Comunes'][$in]['total'] = $bil_val['bil_total'];
            //Generar el campo del total a pagar por apartamento
            $sum = 0;
            $sum_total = 0;
            foreach($content[$apt_val['bui_apt']]['Comunes'] as $apt => $v){
                $sum += $v['porcentaje'];
                $sum_total += $v['total'];
            }
            $content2[$apt_val['bui_apt']]['previo'] = -$apt_val['bui_balance'];
            $content2[$apt_val['bui_apt']]['actual'] = $sum;
            $content2[$apt_val['bui_apt']]['total'] = -$apt_val['bui_balance'] + $sum;
            $lastapt = $content[$apt_val['bui_apt']];
        }
        //fondos
        foreach ($funds as $n => $value) {
            $valor = numToEng($value['def']);

            if($value['type'] == 1){
                $content[$apt_val['bui_apt']][$value['name']][$value['name']]['nombre'] = $value['def'].' %';
                $content[$apt_val['bui_apt']][$value['name']][$value['name']]['porcentaje'] = round($sum * ($valor /100), 2);
                $content[$apt_val['bui_apt']][$value['name']][$value['name']]['total'] = round($sum_total * ($valor / 100), 2);
            }elseif($value['type'] == 2){
                $content[$apt_val['bui_apt']][$value['name']][$value['name']]['nombre'] = 'Bs. '.$value['def'];
                $content[$apt_val['bui_apt']][$value['name']][$value['name']]['porcentaje'] = round($valor / $actives, 2);
                $content[$apt_val['bui_apt']][$value['name']][$value['name']]['total'] = $valor;
            }
            $lastapt = $content[$apt_val['bui_apt']];
        }
    }

    // Se genera el nuevo sumario
    foreach ($lastapt as $categoria => $datos) {
        foreach ($datos as $num => $valor) {
            $summary[$categoria][$valor['nombre']] = $valor['total'];
        }
    }

    $tot = 0; // Total de los gastos y fondos
    foreach ($summary as $key => $cat) {
        foreach ($cat as $item => $value2) {
            $tot += $value2;
        }
    }

    // Se genera la cabecera
    $head = ['fecha' => date('d-m-y'), 'Creador' => $user, 'Periodo' => $lap_ar[0]['lap_name'], 'Gen Num' => $fac_number,'Num Aptos' => $actives, 'MCD' => $porc, 'Monto Total' => $tot, 'Balance a la fecha' => ($balance + $tot)];

    //Se construye el array
    $table =    ['head' => $head,
                'summary' => $summary,
                'content' => $content,
                'charges' => $content2];
    //Graba contenidos temporales de lo que se va a grabar en charges
    $type_json = json_encode($table) or die(json_last_error_msg());
    $file = fopen(ROOTDIR."files/invoices/$bui/FAC-".$fac_number.'.json', 'w');
    fwrite($file, $type_json);
    fclose($file);
    return $table;

    /*
    //Graba contenidos temporales de lo que se va a grabar en charges
    $charges_json = json_encode($content2) or die(json_last_error_msg());
    $file_cha = fopen(ROOTDIR.'core/charges' .$fac_number .'.json', 'w');
    fwrite($file_cha, $charges_json);
    fclose($file_cha); */
}

function save_fact($fac_number){

    //Graba los datos temporales en charges
    $file = fopen(ROOTDIR."files/invoices/$bui/FAC-" .$fac_number. '.json', "r");
    $b = fgets($file);
    $c = json_decode($b);

    // Agrega a los gastos en cuestión el periodo
    $lap_name = $c->{'head'}->{'Periodo'};
    $q = "SELECT lap_id FROM lapses WHERE lap_name = '$lap_name'";
    $r = q_exec($q);
    $lapse = query_to_assoc($r)[0]['lap_id'];
    $q2 = "UPDATE bills SET bil_lapse_fk = '$lapse' WHERE bil_lapse_fk = 99";
    $r2 = q_exec($q2);
    // Actualizar la tabla funds
    // En el primer bucle se debe descartar los gastos comunes
    // El segundo bucle es porque los datos estan en otro objeto
    $fundsArray = [];
    foreach ($c->{'summary'} as $name => $fund) {
        if($name != 'Comunes'){
            foreach ($fund as $ind => $monto) {
                $qe = "UPDATE funds SET fun_balance = fun_balance + $monto WHERE fun_name = '$name'";
                $re = q_exec($qe);
            }
        }
    }

    foreach ($c->{'charges'} as $apto => $value) {
        $charg[$apto] = $value->{'total'};
    }
    //Se actualiza bui_balance
    foreach($charg as $apt => $total){
        $q = "UPDATE buildings SET bui_balance = bui_balance - $total WHERE bui_apt = '$apt' AND bui_name = '$bui'";
        $r = q_exec($q);
    }
    return "Guardado con éxito";
}

function discard($fac_number){
    $q = "UPDATE bills SET bil_lapse_fk = 0 WHERE bil_lapse_fk = 99";
    $r = q_exec($q);
    //elimina los datos temporales y la factura. json
    if(file_exists(ROOTDIR."files/invoices/$bui/FAC-" .$fac_number .'.json')) {
        unlink(ROOTDIR."files/invoices/$bui/FAC-" .$fac_number .'.json');
        $resp = "Borrado con éxito";
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

    $q = "SELECT bui_id, bui_apt FROM buildings WHERE bui_assigned = 1 AND bui_name = '$bui'";
    $r = q_exec($q);
    $r_asc = query_to_assoc($r);
    $apt_ar = ["large" => 0, "med" => 0, "small" => 0];
    $array = [ "A" => 3, "B" => 2, "C" => 2, "D" => 3, "E" => 2, "F" => 1, "G" => 1, "H" => 2];
    for($i = 0; $i < sizeof($r_asc); $i++){
        $number = $r_asc[$i]['bui_apt'];
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
