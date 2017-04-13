<?php
session_start();
require 'header.php';
require 'menu.php';
?>
    <script src="/minha/js/forms.js" charset="utf-8"></script>
    <div class="" id='apart' hidden>
        <?php echo apartToString(); ?>
    </div>
        <h2 align="center">Añadir Usuario</h2>
        <form class="" action="add_user.php" method="post">
            <table align="center">
                <tr>
                    <td>Nombre:</td>
                    <td><input type="text" name="name" value="nombre" onblur="capitalize(this)" required></td>
                </tr>
                <tr>
                    <td>Apellido:</td>
                    <td><input type="text" name="surname" value="apellido" onblur="capitalize(this)" required></td>
                </tr>
                <tr>
                    <td>C.I.</td>
                    <td><input type="text" name="ci" value="v999999" onblur="capitalize(this)" required></td>
                </tr>
                <tr>
                    <td>Apartamento:</td>
                    <td><input type="text" name="number" value="01A" onblur="check_number(this)" required></td>
                </tr>
                <tr>
                    <td>Correo-e:</td>
                    <td><input type="email" name="email" value="un@correo" onblur="lowercase(this)" required></td>
                </tr>
                <tr>
                    <td>Clave:</td>
                    <td><input type="password" name="pwd" id='pwd' value="1234" required></td>
                </tr>
                <tr>
                    <td>Repita clave:</td>
                    <td><input type="password" name="rpwd" id='rpwd' value="1234" required onblur="val_pwd()"></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <div class="warning" id="pwd_e" style="display:none">
                        las claves no coinciden
                        </div>
                    </td>

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
            <div class="button_box" align="center">
                <button type="submit" id='submit' name="button" class="button_hot principal" >Enviar</button>
                <button type="button" name="button" class="button_hot secundary" onclick="window.location.href='main.php'">Regresar</button>
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
