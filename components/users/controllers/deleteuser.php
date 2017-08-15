<?php
/* components/users/controllers/deleteuser.php
 *
 *
 * Llamada asíncrona
 */
defined('_EXE') or die('Acceso restringido');

$id = (integer)$_POST['id'];

include $basedir .'models/users.php';

echo deleteUser($id);
