<?php
/*
 *
 *
 */
//

$panel = array(
    'title'     => 'Anuncios:',
    'body'      => 'Nuevo usuario, información aquí'
);

$loader = new Twig_Loader_Filesystem(ROOTDIR.'/');
$twig = new Twig_Environment($loader);

echo $twig->render(
    'views/widgets/panel.html.twig',
    array('panel' => $panel)
);
