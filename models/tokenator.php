<?php

function createTokenDir(){

    $date = new DateTime();
    $tokendirname = $date->format('Ymd');
    $dirs = scandir(VARDIR);

    foreach($dirs as $dir){

        if(is_dir(VARDIR.$dir) && $dir != $tokendirname
        && ($dir != '..') && ($dir != '.')){

            $files = scandir(VARDIR.$dir);

            foreach($files as $file){

                if(is_file(VARDIR.$dir.'/'.$file) && strlen($file) == 32){
                    unlink(VARDIR.$dir.'/'.$file);
                    //echo "unlink: ".VARDIR.$dir.'/'.$file; echo "<br>";
                }
            }

            if(count(scandir(VARDIR.$dir)) <= 2){
                rmdir(VARDIR.$dir);
                //echo 'rmdir: '.VARDIR.$dir."<br>";
            }
        }
    }

    if(!is_dir(VARDIR.$tokendirname)) mkdir(VARDIR.$tokendirname);

    return VARDIR.$tokendirname.'/';
}

function createFormToken(){

    $token = md5(microtime(true).SECRET);

    $tokendir = createTokenDir();

    if(touch($tokendir.$token)){
        return $token;
    }
    else{
        return false;
    }
}

function checkFormToken($token){

    $tokendir = createTokenDir();

    if(is_file($tokendir.$token)){
        return true;
    }
    else{
        die('{"status": false, "msg": "Por favor recargue la página."}');
    }
}
