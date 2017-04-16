<?php
//Area de entrada después de la autenticación. 
session_start();
if(isset($_SESSION['user']) && $_SESSION['status'] == 'active'){
    require 'header.php';
    require 'menu.php';

    // En esta área se colocarán las notificaciones

    require 'footer.php';
}else{
    exit("Área restringida.");
}

  ?>
