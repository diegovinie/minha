<?php
//print_r($_SERVER);
$time_ini = microtime(true);

// Directorio raiz
define('ROOTDIR', dirname(__FILE__));

// Carga los parámetros
$parameters = simplexml_load_file(ROOTDIR.'/parameters.xml');

// Directorio de componentes
define('COMDIR', ROOTDIR.'/'.$parameters->principal->components); 

// Directorio de varios
define('VARDIR', ROOTDIR.'/'.$parameters->principal->vardir);

// Nombre del proyecto
define('NAME', $parameters->principal->name);
define('VERSION', $parameters->principal->version);

// Frase secreta
define('SECRET', $parameters->principal->secret);

// Datos para conectarse a la base de datos:
define('DB_HOST', $parameters->database->hostname);
define('DB_USER', $parameters->database->user);
define('DB_PWD', $parameters->database->password);
define('DB_NAME', $parameters->database->db_name);

// Datos servidor de correo
define('EMAIL', $parameters->principal->adminemail);

// Password por defecto
define('DEF_PWD', $parameters->principal->defpwd);

// Ubicación de la plantilla
define('TEMPLATE', 'vendor/'.$parameters->principal->template.'/');
// Token para evitar cache
define('TOKEN', md5($time_ini));

// Controlador de acceso
define('ACCESS_CONTROL', $parameters->principal->security_control);

// Datos de prueba
define('DEMO', false);
define('PRUEBA', true);
define('VIDEO', false);

// en caso de estar en subcarpeta
if(dirname(__FILE__) == $_SERVER['DOCUMENT_ROOT']){
    define('ALIAS', '');
}else{
    define('ALIAS', $parameters->principal->alias.'/');
}

setlocale(LC_TIME, 'es_VE.UTF-8');

if(!isset($_SESSION)) session_start();

include ROOTDIR.'/vendor/autoload.php';

include ROOTDIR.'/controllers/globals.php';

// La clase LoadTwigWithGlobals
include ROOTDIR.'/controllers/LoadTwigWithGlobals.php';
