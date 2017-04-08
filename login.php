<?php
session_start();
session_unset();
session_destroy();
require 'header.php';
 ?>

<h1 align="center">Ingresar</h1>
<form class="" action="login.php" method="post">
    <table align="center">
        <tr>
            <td>Usuario: </td>
            <td><input type="text" name="user" value=""></td>
        </tr>
        <tr>
            <td>Clave: </td>
            <td><input type="password" name="pwd" value=""></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><button type="submit" name="button">Enviar</button></td>
        </tr>
    </table>
</form>

<?php
require 'footer.php';
extract($_POST);

if(isset($user) && isset($pwd)){
    require 'server.php';
    $con = connect();
    $q = "SELECT user_user, user_pwd, user_type FROM users WHERE user_user = '$user' AND user_pwd = '$pwd'";
    $r = q_exec($q);
    $user_val = [];

    if(mysql_num_rows($r) == 1){
        echo "entra";
        foreach (mysql_fetch_assoc($r) as $key => $value) {
            $user_val[$key] = $value;
        }
        session_start();
        $_SESSION['user'] = $user;
        $_SESSION['status'] = 'active';

        switch ($user_val['user_type']) {
            case 1:
                $_SESSION['type'] = 1;
                echo "ir a administrador";
                header("Location: main.php");
                break;
            case 2:
                $_SESSION['type'] = 2;
                echo "ir a usuario";
                header("Location: main.php");
                break;
            default:
                echo "ha ocurrido un error";
                break;
        }
    }else{
        echo "no entra";
    }

}

 ?>
