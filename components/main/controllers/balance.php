<?php
/* components/main/controllers/balance.php
 *
 * Proviene de petición asíncrona
 * Devuelve json desde el modelo
 */
//defined('_EXE') or die('Acceso restringido');

$napt = (int)$_SESSION['apt_id'];

include $basedir .'models/main.php';
echo getBalance($napt);
