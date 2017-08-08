<?php

function tableBuilder($table){

    if($table){
        $loader = new Twig_Loader_Filesystem(ROOTDIR.'/');
        $twig = new Twig_Environment($loader);

        return $twig->render(
            'views/tables/table1.html.twig',
            array(
                'table' => $table
            )
        );
    }else{
        return false;
    }


}
