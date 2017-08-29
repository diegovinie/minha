<?php

if($route[1] == 'get'){

    if(isset($route[2])){

        if(isset($route[3])){

            $template = "/views/{$route[2]}/{$route[3]}.twig";
        }
        else{
            $template = "/views/{$route[2]}.twig";
        }
    }
}

$loader = new Twig_Loader_Filesystem(ROOTDIR.'/');

$twig = new Twig_Environment($loader);

echo $twig->render($template);
