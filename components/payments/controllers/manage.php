<?php
/* components/payments/controllers/manage.php
 *
 *
 * Genera la vista
 */
defined('_EXE') or die('Acceso restringido');

$edf = (string)$_SESSION['edf'];
$aptid = (int)$_SESSION['apt_id'];
$buiid = (int)$_SESSION['bui_id'];

include $basedir .'/models/managepayments.php';
$tables['pending'] = json_decode(pendingPayments($buiid));
$tables['refused'] = json_decode(refusedPayments($buiid));
$tables['approved'] = json_decode(approvedPayments($buiid));

//var_dump($tables); die;

// Creación del array $table_template
$loader = new Twig_Loader_Filesystem(ROOTDIR.'/');
$twig = new Twig_Environment($loader);

foreach ($tables as $key => $value) {

    if($value->status == true){

        $table_template[$key] = $twig->render(
            'views/tables/table2.html.twig',
            array(
                'table' => $value->table
            )
        );
    }
    else{
        $table_template[$key] = $value->table;
    }
}


// Datos para los botones
$href = array(
    "register"  => "/index.php/register",
    "recovery"  => "/index.php/recovery"
);

// javascript a incluir
$js = array(
    "manage"  => "/components/payments/js/managepayments.js",
    "functions" => "/js/functions.js"
);

$twig = new LoadTwigWithGlobals($_globals['view']);
$twig->addExtension(new Twig_Extension_StringLoader());
$twig->getExtension('Twig_Extension_Core')
    ->setNumberFormat(2, ',', '.');

echo $twig->render(
    'components/payments/views/manage.html.twig',
    array('a' => $href,
    'js' => $js,
    'pending' => $table_template['pending'],
    'refused' => $table_template['refused'],
    'approved' => $table_template['approved']
));
