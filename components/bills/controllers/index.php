<?php
/* components/bills/controllers/index.php
 *
 *
 * Genera la vista
 */
defined('_EXE') or die('Acceso restringido');
//include $basedir.'models/finances.php';

include $basedir.'models/bills.php';

$buiid = (int)$_SESSION['bui_id'];
$lapseid = 0;

$tables['bills'] = json_decode(getBillsByLapse($buiid, $lapseid));

//var_dump($tables); die;
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
    "finances"  => "/components/finances/js/finances.js",
    "functions" => "/js/functions.js"
);



$twig = new LoadTwigWithGlobals($_globals['view']);
$twig->addExtension(new Twig_Extension_StringLoader());
$twig->getExtension('Twig_Extension_Core')
    ->setNumberFormat(2, ',', '.');

echo $twig->render(
    'components/bills/views/index.html.twig',
    array(
        'bills' => $table_template['bills'],
    )
);
