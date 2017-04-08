<?php
session_start();
if(isset($_SESSION['user']) && $_SESSION['status'] == 'active'){
    require 'header.php';
    require 'menu.php';
    echo "Bienvenido, ".$_SESSION['user'];
    require 'footer.php';
}else{
    exit("Área restringida.");
}

  ?>
