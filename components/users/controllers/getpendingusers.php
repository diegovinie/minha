<?php
/* components/users/controllers/getpendingusers.php
 *
 *
 * Llamada asíncrona
 */
defined('_EXE') or die('Acceso restringido');

$edf = (string)$_SESSION['edf'];

include $basedir .'/models/users.php';

$res = json_decode(getPendingUsers($edf));

if($res->table != false){

    include ROOTDIR.'/controllers/tablebuilder.php';
    echo tableBuilder($res->table);

}else{
    echo false;
}
