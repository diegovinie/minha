<?php
/* components/security/controllers/tokenator.php
 *
 */


function createFormToken(){

    $time = microtime(true);
    $client = $_SERVER['REMOTE_ADDR']? $_SERVER['REMOTE_ADDR'] : false;

    if(!$client) return false;

    $json = json_encode(array($client, $time, SECRET));

    //$token = md5($json);
    //$handle = fopen(ROOTDIR.'/'.VARDIR.$token, 'w+');

    if(!isset($_SESSION)) session_start();
    $_SESSION['token'] = $token;

    return $token;
};

function checkFormToken($token){

    if(!isset($_SESSION)) session_start();
    
    if($_SESSION['token'] == $token)
    {
        unlink(ROOTDIR.'/'.VARDIR.$token);

        return true;
    }else{

        return false;
    }
}
