<?php
require 'datos.php';
if(isset($_COOKIE['remember'])){
    extract($_COOKIE);
    include 'server.php';
    $con = connect();
    $q = "DELETE FROM cookies WHERE coo_val = '$remember'";
    $r = q_exec($q);
    setcookie('remember', '', time()-3600, '/');
}
header('Location: login.php');
 ?>
