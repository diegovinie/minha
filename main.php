<?php
session_start();
if(isset($_SESSION['user']) && $_SESSION['status'] == 'active'){
    require 'header.php';
    require 'menu.php';
    echo "<div align='right'>Bienvenido, ".$_SESSION['name']."</div>";

    require 'footer.php';
}else{
    exit("Área restringida.");
}

  ?>
