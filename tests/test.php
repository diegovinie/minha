<?php
/*
 * php test.php host:'hostname' path:'path/to/the/' post:array session:int
 *
 */

foreach ($argv as $value) {
    list($a, $b) = split(':', $value, 2);
    $inputArgs[$a] = $b;
}

if(isset($inputArgs['session'])){
    include "sessions/{$inputArgs['session']}.php";
}

if(isset($inputAgs['post'])){
    include "posts/{$inputArgs['post']}.php";
}

if(isset($inputArgs['model'])){
    list($com, $model, $fun) = split('_', $inputArgs['model']);
    define('_EXE', TOKEN);
    include "../components/$com/models/$model.php";
}

//$_SERVER['PATH_INFO'] = $inputArgs['path'];

//include '../public_html/index.php';
