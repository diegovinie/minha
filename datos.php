<?php
// Datos: deberán ser configurados la primera vez por settings.php
$db_host = 'localhost';
$db_user = 'root';
$db_pwd = 'altura';
$db_name = 'bd_minha';
$alias = 'minha';
$template = 'startbootstrap-sb-admin-2-gh-pages';
$name = 'Minha Administradora';
$defpwd = '1234';

// Datos para conectarse a la base de datos:
define('DB_HOST', $db_host);
define('DB_USER', $db_user);
define('DB_PWD', $db_pwd);
define('DB_NAME', $db_name);
define('DEF_PWD', $defpwd);

// Nombre del proyecto
define('NAME', $name);

// en caso de estar en subcarpeta
if(dirname(__FILE__) == $_SERVER['DOCUMENT_ROOT']){
    define('ALIAS', '');
}else{
    define('ALIAS', $alias.'/');
}

// Directorio raíz para la navegación de PHP:
define('ROOTDIR', $_SERVER['DOCUMENT_ROOT'].'/'.ALIAS);

// Directorio raíz referenciada http
define('PROJECT_HOST', '//'.$_SERVER['HTTP_HOST'].'/'.ALIAS);

define('TEMPLATE', 'vendor/'.$template.'/');

setlocale(LC_TIME, 'es_VE.UTF-8');

// Constante del MCM de los apartamentos de A17:
define('FRAC', 0.4166);

$file = fopen('hostname', 'w');
fwrite($file, PROJECT_HOST);
fclose($file);

function genA17(){
    //Retorna un array con todos los apartamentos de A17
    function apartToString(){
        $level = 0;
        $num = 1;
        for($level = 1; $level <= 15; $level++){
            $j = 0;
            $letters = 'ABCDEFGH';
            $a = '';
            $let = '';
            for($j = 0; $j < strlen($letters); $j++){
                $let = $letters[$j];
                $apart[$num] = '"'.$level.$let.'"';
                $num++;
            }
        }
        $array_apart = implode(',', $apart);
        return '['.$array_apart.']';
    }
    $apts = apartToString();
    $A17 = '{"apts": ' .$apts .'}';
    $file = fopen('files/A17.json', 'w');
    fwrite($file, $A17);
    fclose($file);
    return $A17;
}


//Recibe un float y lo pasa a notación inglesa, ignora la cantidad de decimales
function numToEng($num){
    $num = str_replace(',', '.', $num = str_replace('.', '', $num));
    return floatval($num);
}

function escape_array($array){
    $result = [];
    foreach ($array as $key => $value) {
        $result[$key] = mysql_escape_string($value);
    }
    return $result;
}
 ?>
