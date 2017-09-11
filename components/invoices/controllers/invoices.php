<?php


$edf = $_SESSION['edf'];
$prx = $_SESSION['prefix'];

$dir = ROOTDIR."/files/{$prx}invoices/$edf";

if(!is_dir($dir)){
    die('Problema con el directorio');
}
else{
    $dirHnd = opendir($dir);
    $batch = array();

    while(false !== ($fileName = readdir($dirHnd))){

        if($fileName != '.' && $fileName != '..'){
            $f = array();

            $a = substr($fileName, 0, strrpos($fileName, "."));
            $b = substr($a, 4, strlen($a));
            $month = substr($b, -2, strlen($b));
            $year = substr($b, 0, 4);
            $ficheros[$month.'/'.$year] = $b;
            $f['id'] = $b;
            $f['name'] = $month.'/'.$year;
            $batchs[] = $f;
        }
    }
}

$js = array(
    'display' => '/index.php/assets/invoices/js/displayinvoice.js'
);

$twig = new LoadTwigWithGlobals($_globals['view']);
$twig->addExtension(new Twig_Extension_StringLoader());

echo $twig->render(
    'components/invoices/views/invoices.html.twig',
    array(
        'batchs' => $batchs,
        'js'     => $js
    )
);
