<?php
require 'datos.php';
include 'server.php';
$con = connect();
echo "entró a resetdb";
echo "<br>";

$q1 = "DROP TABLE `A17`, `accounts`, `banks`, `bills`, `charges`, `db_logs`, `funds`, `lapses`, `movements`, `payments`, `spendings_types`, `userdata`, `users`, `usual_providers`";

$r1 = q_exec($q1);

print_r($r1);
echo "<br>";
echo "Limpieza ejecutada";
echo "<br>";
sleep(2);
echo "Cargando base de datos";
echo "<br>";
// Name of the file
$filename = 'bd_fresh.sql';

// Temporary variable, used to store current query
$templine = '';
// Read in entire file
$lines = file($filename);
// Loop through each line
foreach ($lines as $line){
    // Skip it if it's a comment
    if (substr($line, 0, 2) == '--' || $line == '')
        continue;

    // Add this line to the current segment
    $templine .= $line;
    // If it has a semicolon at the end, it's the end of the query
    if (substr(trim($line), -1, 1) == ';'){
        // Perform the query
        mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
        // Reset temp variable to empty
        $templine = '';
    }
}
 echo "Tables imported successfully";
 ?>
