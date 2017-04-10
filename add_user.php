<?php
session_start();
require 'header.php';
require 'menu.php';
?>
        <h1 align="center">Añadir Usuario</h1>
        <form class="" action="add_user.php" method="post">
            <table align="center">
                <tr>
                    <td>Nombre:</td>
                    <td><input type="text" name="name" value="nombre" required></td>
                </tr>
                <tr>
                    <td>Apellido:</td>
                    <td><input type="text" name="surname" value="apellido" required></td>
                </tr>
                <tr>
                    <td>C.I.</td>
                    <td><input type="text" name="ci" value="v999999" required></td>
                </tr>
                <tr>
                    <td>Apartamento:</td>
                    <td><input type="text" name="number" value="01A" required></td>
                </tr>
                <tr>
                    <td>Correo-e:</td>
                    <td><input type="email" name="email" value="un@correo" required></td>
                </tr>
                <tr>
                    <td>Clave:</td>
                    <td><input type="password" name="pwd" value="1234" required></td>
                </tr>
                <tr>
                    <td>Repita clave:</td>
                    <td><input type="password" name="rpwd" value="1234" required></td>
                </tr>
                <tr>
                    <td>Tipo de usuario:</td>
                    <td>
                        <select class="" name="type" required>
                            <option selected>Seleccionar</option>
                            <option value="1">Administrador</option>
                            <option value="2">Usuario Registrado</option>
                        </select>
                </tr>
            </table>
            <div class="">
                <button type="submit" name="button" >Enviar</button>
                <button type="button" name="button" onclick="window.location.href='main.php'">Regresar</button>
            </div>
        </form>
<?php
extract($_POST);
$session_user = $_SESSION['user'];

if( isset($name) &&      isset($surname) &&
    isset($ci) &&        isset($number) &&
    isset($email) &&     isset($pwd)    &&
    $_SESSION['type'] == 1){
    require 'server.php';
    $con = connect();
    $q = "SELECT user_id FROM users WHERE user_user = '$email'";
    $r = q_exec($q);

    if(mysql_num_rows($r) == 0){
        $q1 = "INSERT INTO users VALUES (NULL, '$email', '$pwd', '$type', 1, '$session_user', NULL)";
        $r1 = q_log_exec($session_user, $q1);
        $q2 = "SELECT user_id FROM users WHERE user_user = '$email'";
        $r2 = q_exec($q);
        $r2s = mysql_fetch_array($r2)[0];
        $q3 = "INSERT INTO userdata VALUES (NULL, '$name', '$surname', '$ci', '$number', $r2s)";
        $r3 = q_exec($q3);

        ?> <script type="text/javascript">
            alert('Usuario agregado');
        </script> <?php
    }else{
        ?><script type="text/javascript">
            alert('Usuario ya existe');
        </script> <?php
    }
}
require 'footer.php';
 ?>
