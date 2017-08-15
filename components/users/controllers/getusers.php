<?php
/* components/users/controllers/manage.php
 *
 *
 * Llamada asíncrona
 */
defined('_EXE') or die('Acceso restringido');

$bui = (string)$_SESSION['bui'];

include $basedir .'/models/users.php';

$res = json_decode(getUsers($bui));

if($res->table != false){

    include ROOTDIR.'/controllers/tablebuilder.php';
    echo tableBuilder($res->table);

}else{
    echo false;
}
