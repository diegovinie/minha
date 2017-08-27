<?php

$months = array(
    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
);

$date = new DateTime;
$curMonth = $date->format('m');
$curYear = $date->format('Y');

$lapses = array();

for ($y=2017; $y <= $curYear; $y++) {

    foreach ($months as $n => $m) {
        $row = array();

        $row['name'] = "$m $y";
        $row['month'] = $n + 1;
        $row['year'] = $y;

        $lapses[] = $row;

        if($y == $curYear
            && $n + 1 == $curMonth+1) break;
    }
}
