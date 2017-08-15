<?php
/* components/users/controllers/getnotes.php
 *
 *
 * Llamada asíncrona
 */
defined('_EXE') or die('Acceso restringido');

include $basedir .'models/profile.php';

$buiid = (integer)$_SESSION['number_id'];

echo getNotesFromBuildings($buiid);
