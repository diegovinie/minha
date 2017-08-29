<?php
/* components/users/controllers/getnotes.php
 *
 *
 * Llamada asíncrona
 */
defined('_EXE') or die('Acceso restringido');

include $basedir .'models/profile.php';

$aptid = (integer)$_SESSION['apt_id'];

echo getNotesFromApartments($aptid);
