<?php
/* components/finances/controllers/createaccount.php
 *
 *
 * Genera la vista
 */
defined('_EXE') or die('Acceso restringido');

include ROOTDIR.'/models/tokenator.php';

$buiid = (int)$_SESSION['bui_id'];

$name = (string)$_POST['name'];
$habid = (int)$_POST['user'];
$typeid = (int)$_POST['type'];
$default = (float)$_POST['amount'];

include $basedir .'models/createaccount.php';

echo addAccount($buiid, $name, $typeid, $default, $habid);
