<?php

defined('_EXE') or die('Acceso restringido');



// Se revisa si tiene sesión guardada en cookie
if(isset($_COOKIE['remember'])){
    $remember = mysql_escape_string($_COOKIE['remember']);
    include ROOTDIR .'/components/security/models/remembersession.php';
    $res = json_decode(checkRemember($remember));
    $globals['name'] = $_SESSION['name'];
}
else{
    if(!isset($_SESSION)) session_start();
}

if(!isset($_SESSION['user_id'])
|| $_SESSION['status'] != 'active')
{
    header("Location: /index.php/login");
    exit;
}
