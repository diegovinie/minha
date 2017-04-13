<?php
require 'header.php';
 ?>
</header>
<main>
<script src="/minha/js/forms.js" charset="utf-8"></script>

<div id="apart" hidden>
    <?php echo apartToString(); ?>
</div>
 <h1 align="center">Registrarse</h1>
 <form class="" action="signup.php" method="post">
     <table align="center">
         <tr>
             <td>Nombre:</td>
             <td><input type="text" name="name" value="nombre" required onblur="capitalize(this);"></td>
         </tr>
         <tr>
             <td>Apellido:</td>
             <td><input type="text" name="surname" value="apellido" required onblur="capitalize(this);"></td>
         </tr>
         <tr>
             <td>C.I.</td>
             <td><input type="text" name="ci" value="v999999" required onblur="capitalize(this);"></td>
         </tr>
         <tr>
             <td>Apartamento:</td>
             <td><input type="text" name="number" value="01A" required onblur="check_number(this)"></td>
         </tr>
         <tr>
             <td>Correo-e:</td>
             <td><input type="email" name="email" value="un@correo" required onblur="lowercase(this);"></td>
         </tr>
         <tr>
             <td>Clave:</td>
             <td><input type="password" name="pwd" id="pwd" value="1234" required></td>
         </tr>
         <tr>
             <td>Repita clave:</td>
             <td><input type="password" name="rpwd" id="rpwd" value="1234" required onblur="val_pwd()"></td>
         </tr>
         <tr>
             <td colspan="2" align="center">
                 <div class="warning" id="pwd_e" style="display:none">
                 las claves no coinciden
                 </div>
             </td>

         </tr>
         <tr>
             <td><input type="text" name="type" value="2" hidden></td>
         </tr>
     </table>
     <div class="buttons1" align="center">
         <button type="submit" name="button" id="submit" class="button_hot principal">Enviar</button>
         <button type="button" name="button" onclick="window.location.href='login.php'" class="button_hot secundary">Regresar</button>
     </div>

 </form>

 <?php
 extract($_POST);

 if( isset($name) &&      isset($surname) &&
     isset($ci) &&        isset($number) &&
     isset($email) &&     isset($pwd)){

     $c = $number[strlen($number) - 1];
     $array = [ "A" => 3, "B" => 2, "C" => 2, "D" => 3, "E" => 2, "F" => 1, "G" => 1, "H" => 2];
     foreach ($array as $key => $value) {
         if($key == $c)
            $d = $value;
     }
     $weight = FRAC * $d;

     require 'server.php';
     $con = connect();
     $q = "SELECT user_id FROM users WHERE user_user = '$email'";
     $r = q_exec($q);
     if(mysql_num_rows($r) == 0){
         $q1 = "INSERT INTO users VALUES (NULL, '$email', '$pwd', 2, 0, 'register:$email', NULL)";
         $r1 = q_log_exec('register:$email', $q1);
         $q2 = "SELECT user_id FROM users WHERE user_user = '$email'";
         $r2 = q_exec($q);
         $r2s = mysql_fetch_array($r2)[0];
         $q3 = "INSERT INTO userdata VALUES (NULL, '$name', '$surname', '$ci', '$number', '$weight', $r2s)";
         $r3 = q_exec($q3);

         ?> <script type="text/javascript">
             alert('Gracias por registrarse, en breve será activado');
             window.location.href = 'login.php';
         </script> <?php
     }else{
         ?><script type="text/javascript">
             alert('Usuario ya existe');
         </script> <?php
     }

 }
 require 'footer.php';
  ?>
