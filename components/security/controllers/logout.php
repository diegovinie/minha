<?php
/*
 * components/security/controllers/logout.php
 *
 * Controlador
 */
defined('_EXE') or die('Acceso restringido');

if(isset($_COOKIE['remember'])){
    $remember = mysql_escape_string((string)$_COOKIE['remember']);

    include $basedir .'models/remembersession.php';
    $res = delRemember($remember);

    if($res->status == true) setcookie('remember', '', time()-3600, '/');
}

if(!isset($_SESSION)) session_start();
session_unset();
session_destroy();
header('Location: /index.php/login');

 ?>
