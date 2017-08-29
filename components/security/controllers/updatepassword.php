<?php
/*
 *
 *
 */
defined('_EXE') or die('Acceso restringido');

$userid = (int)$_SESSION['user_id'];
$old = mysql_escape_string($_POST['old']);
$new = mysql_escape_string($_POST['new']);

include ROOTDIR.'/components/security/models/authentication.php';
echo setPasswordFromOld($userid, $old, $new);
