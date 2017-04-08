<?php
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
                    <td><input type="text" name="type" value="1" required></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <button type="submit" name="button" >Enviar</button>
                    </td>
                </tr>
            </table>
        </form>
<?php
require 'footer.php';
extract($_POST);

if( isset($name) &&      isset($surname) &&
    isset($ci) &&        isset($number) &&
    isset($email) &&     isset($pwd) ){
    require 'server.php';
    $con = connect();
    $q = "SELECT user_user FROM users WHERE user_user = '$email'";
    $r = q_exec($q);
    echo "total es ".mysql_num_rows($r);
    if(mysql_num_rows($r) == 0){
        $q1 = "INSERT INTO users VALUES (NULL, '$email', '$pwd', '$type')";
        $r1 = q_exec($q1);
        $q2 = "INSERT INTO userdata VALUES (NULL, '$name', '$surname', '$ci', '$number')";
        $r2 = q_exec($q2);
        echo "usuario agregado";
    }else{
        echo 'registrarse';
    }
}

 ?>
