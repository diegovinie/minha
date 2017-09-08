<?php
/* components/finances/controllers/finances.php
 *
 *
 * Genera la vista
 */
defined('_EXE') or die('Acceso restringido');
include $basedir.'models/finances.php';

$buiid = (int)$_SESSION['bui_id'];

// Consultas para la formación de tablas
$tables['accounts'] = json_decode(getAccountsForTables($buiid));
$tables['funds'] = json_decode(getFundsForTables($buiid));
$tables['apts']= json_decode(getAptBalancesForTables($buiid));

// Consultas para determinar el balance total
$data['accounts'] = json_decode(getCurrentBalance($buiid));
$data['funds'] = json_decode(getTotalFunds($buiid));

// Creación del array $table_template
$loader = new Twig_Loader_Filesystem(ROOTDIR.'/');
$twig = new Twig_Environment($loader);

foreach ($tables as $key => $value) {
    $table_template[$key] = $twig->render(
        'views/tables/table2.html.twig',
        array(
            'table' => $value->table
        )
    );
}

// Datos para los botones (no aún)
$href = array(
    "register"  => "/index.php/register",
    "recovery"  => "/index.php/recovery"
);

// javascript a incluir
$js = array(
    "finances"  => "/index.php/assets/finances/js/finances.js",
    "functions" => "/js/functions.js"
);


$twig = new LoadTwigWithGlobals($_globals['view']);
$twig->addExtension(new Twig_Extension_StringLoader());
$twig->getExtension('Twig_Extension_Core')
    ->setNumberFormat(2, ',', '.');

echo $twig->render(
    'components/finances/views/finances.html.twig',
    array(
      'a' => $href,
      'js' => $js,
      'data' => $data,
      'accounts' => $table_template['accounts'],
      'funds' => $table_template['funds'],
      'apts' => $table_template['apts']
    )
);
