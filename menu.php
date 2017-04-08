<table border=1 align="center" width=800px>
    <tr>
        <?php
        if(session_status() == 2){
            switch ($_SESSION['type']) {
                case 1: ?>
                    <td align="center"><a href="#">Registrar Pago</a></td>
                    <td align="center"><a href="#">Recibos de Condominio</a></td>
                    <td align="center"><a href="#">Pagos Realizados</a></td>
                    <td align="center"><a href="#">Administracion</a></td>
                    <td align="center"><a href="#">Configuración de Usuarios</a></td>
                    <td align="center"><a href="login.php">Salir</a></td> <?php
                    break;
                case 2: ?>
                    <td align="center"><a href="#">Registrar Pago</a></td>
                    <td align="center"><a href="#">Recibos de Condominio</a></td>
                    <td align="center"><a href="#">Pagos Realizados</a></td>
                    <td align="center"><a href="login.php">Salir</a></td> <?php
                    break;
                default:
                    echo 'ha ocurrido un error.';
                    break;
            }
        }else{
            exit("Sesión terminada.");
        }

         ?>
    </tr>
</table>
