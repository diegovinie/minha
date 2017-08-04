<?php
/*
 *
 *
 */
defined('_EXE') or die('Acceso restringido');

session_start();

$userid = (int)$_SESSION['user_id'];
$old = mysql_escape_string($_POST['old']);
$new = mysql_escape_string($_POST['new']);

include ROOTDIR.'/components/security/models/authentication.php';
echo updatePassword($userid, $old, $new);
