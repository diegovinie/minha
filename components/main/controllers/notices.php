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

$twig = new LoadTwigWithGlobals($_globals['view']);

echo $twig->render(
    'views/widgets/panel.html.twig',
    array('panel' => $panel)
);
