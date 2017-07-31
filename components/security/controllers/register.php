<?php
/* components/security/controllers/register.php
 *
 * Controlador
 * Genera la Vista
 */

$titulo = "Registro";

$href = array(
    "return"    => "/index.php/login"
);

$loader = new Twig_Loader_Filesystem(ROOTDIR.'/');
$twig = new Twig_Environment($loader);

//echo $twig->render('Hello {{ name }}!', array('name' => 'Fabien'));
echo $twig->render(
    'components/security/views/register.html.twig',
    array(
        'titulo'    => $titulo,
        'a'         => $href
    )
);
